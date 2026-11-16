# -*- coding: utf-8 -*-
"""
Utilidades compartidas por los procesadores estadísticos de Calculadora One Milion.

Contrato de entrada (argv[1]):
    {"action": "...", "params": {...}}

Contrato de salida (stdout, una sola línea JSON):
    {"ok": true, "resultado": {...}}
    {"ok": false, "error": "..."}
"""

from __future__ import annotations

import json
import math
import re
import sys
import uuid
import base64
from pathlib import Path

import matplotlib

matplotlib.use("Agg")
import matplotlib.pyplot as plt

BASE_DIR = Path(__file__).resolve().parent
VIEW_DIR = BASE_DIR.parent / "View"
ASSETS_DIR = VIEW_DIR / "assets" / "graficos"

COLOR_BG = "#0f1524"
COLOR_PANEL = "#0a0e1a"
COLOR_TEXT = "#f1f5f9"
COLOR_MUTED = "#94a3b8"
COLOR_GRID = "#1e293b"
COLOR_GREEN = "#00ffaa"
COLOR_CYAN = "#00d9ff"
COLOR_BLUE = "#3b82f6"
COLOR_YELLOW = "#eab308"
COLOR_RED = "#ef4444"
COLOR_PURPLE = "#a855f7"


def configurar_estilo() -> None:
    """Aplica el tema oscuro del proyecto a las figuras de matplotlib."""
    plt.style.use("dark_background")
    plt.rcParams.update(
        {
            "figure.facecolor": COLOR_BG,
            "savefig.facecolor": COLOR_BG,
            "axes.facecolor": COLOR_BG,
            "axes.edgecolor": "#334155",
            "axes.labelcolor": COLOR_MUTED,
            "axes.titlecolor": COLOR_TEXT,
            "xtick.color": COLOR_MUTED,
            "ytick.color": COLOR_MUTED,
            "text.color": COLOR_TEXT,
            "font.family": "DejaVu Sans",
            "axes.grid": True,
            "grid.color": COLOR_GRID,
            "grid.linestyle": "--",
            "grid.alpha": 0.65,
            "legend.facecolor": COLOR_PANEL,
            "legend.edgecolor": "#334155",
        }
    )


def responder(payload: dict) -> None:
    """Imprime una única línea JSON ASCII para que PHP la pueda decodificar."""
    print(json.dumps(payload, ensure_ascii=True))


def fallo(mensaje: str) -> None:
    """Devuelve un error controlado y termina el proceso."""
    responder({"ok": False, "error": str(mensaje)})
    sys.exit(0)


def leer_payload() -> dict:
    if len(sys.argv) < 2:
        fallo("No se recibió el payload JSON desde PHP.")
    texto = sys.argv[1]
    if not texto.lstrip().startswith("{"):
        try:
            texto = base64.b64decode(texto.encode("ascii")).decode("utf-8")
        except Exception as exc:
            fallo(f"No se pudo decodificar el payload base64: {exc}")
    try:
        payload = json.loads(texto)
    except json.JSONDecodeError as exc:
        fallo(f"Payload JSON inválido: {exc}")
    if not isinstance(payload, dict):
        fallo("El payload debe ser un objeto JSON.")
    return payload


def obtener_params(payload: dict) -> dict:
    params = payload.get("params", {})
    if not isinstance(params, dict):
        fallo("El campo 'params' debe ser un objeto JSON.")
    return params


def a_numero(
    valor,
    nombre: str,
    *,
    entero: bool = False,
    minimo: float | None = None,
    maximo: float | None = None,
) -> float | int:
    if valor is None or isinstance(valor, bool):
        fallo(f"El campo '{nombre}' es obligatorio.")
    texto = str(valor).strip().replace(",", ".")
    if texto == "":
        fallo(f"El campo '{nombre}' es obligatorio.")
    try:
        numero = float(texto)
    except ValueError:
        fallo(f"El campo '{nombre}' debe ser un número válido.")
    if not math.isfinite(numero):
        fallo(f"El campo '{nombre}' debe ser un número finito.")
    if entero:
        if abs(numero - round(numero)) > 1e-9:
            fallo(f"El campo '{nombre}' debe ser un número entero.")
        numero = int(round(numero))
    if minimo is not None and numero < minimo:
        fallo(f"El campo '{nombre}' debe ser mayor o igual a {minimo}.")
    if maximo is not None and numero > maximo:
        fallo(f"El campo '{nombre}' debe ser menor o igual a {maximo}.")
    return numero


def a_probabilidad(valor, nombre: str) -> float:
    return float(a_numero(valor, nombre, minimo=0, maximo=1))


def a_booleano(valor, defecto: bool = False) -> bool:
    if valor is None:
        return defecto
    if isinstance(valor, bool):
        return valor
    return str(valor).strip().lower() in {"1", "true", "on", "si", "sí", "yes"}


def a_texto(valor, defecto: str = "") -> str:
    if valor is None:
        return defecto
    return str(valor).strip()


def parsear_lista(valor, nombre: str) -> list[float]:
    if isinstance(valor, (list, tuple)):
        crudos = list(valor)
    else:
        texto = a_texto(valor)
        if not texto:
            fallo(f"El campo '{nombre}' no puede estar vacío.")
        crudos = [parte for parte in re.split(r"[,;\s]+", texto) if parte]
    if not crudos:
        fallo(f"El campo '{nombre}' no contiene valores.")
    return [float(a_numero(item, nombre)) for item in crudos]


def parsear_enteros(valor, nombre: str) -> list[int]:
    numeros = parsear_lista(valor, nombre)
    enteros: list[int] = []
    for numero in numeros:
        if abs(numero - round(numero)) > 1e-9:
            fallo(f"El campo '{nombre}' debe contener solo números enteros.")
        enteros.append(int(round(numero)))
    return enteros


def fmt(valor, decimales: int = 6) -> str:
    """Formatea números para mostrarlos dentro de textos y tablas."""
    if isinstance(valor, bool):
        return "sí" if valor else "no"
    if isinstance(valor, int):
        return str(valor)
    if isinstance(valor, float):
        if not math.isfinite(valor):
            return "—"
        if abs(valor - round(valor)) < 1e-10:
            return str(int(round(valor)))
        texto = f"{valor:.{decimales}f}".rstrip("0").rstrip(".")
        return texto if texto not in {"-0", ""} else "0"
    return str(valor)


def fmt_pct(valor: float, decimales: int = 4) -> str:
    return f"{fmt(valor * 100, decimales)}%"


def normalizar_probabilidades(
    probabilidades: list[float], tolerancia: float = 0.01
) -> tuple[list[float], bool]:
    """Valida que las probabilidades sumen 1 y corrige redondeos pequeños."""
    suma = sum(probabilidades)
    if suma <= 0:
        fallo("La suma de las probabilidades debe ser mayor que cero.")
    if abs(suma - 1.0) > tolerancia:
        fallo(
            f"Las probabilidades deben sumar 1 (suman {fmt(suma, 6)}). "
            "Revisa los valores ingresados."
        )
    normalizado = abs(suma - 1.0) > 1e-9
    if normalizado:
        probabilidades = [p / suma for p in probabilidades]
    return probabilidades, normalizado


def guardar_figura(fig, unidad: str, prefijo: str) -> str:
    """Guarda la figura en View/assets/graficos/<unidad>/ y devuelve su URL relativa."""
    destino = ASSETS_DIR / unidad
    destino.mkdir(parents=True, exist_ok=True)
    for anterior in destino.glob(f"{prefijo}_*.png"):
        try:
            anterior.unlink()
        except OSError:
            pass
    nombre = f"{prefijo}_{uuid.uuid4().hex[:12]}.png"
    ruta = destino / nombre
    try:
        fig.tight_layout()
        fig.savefig(ruta, dpi=110, bbox_inches="tight", facecolor=fig.get_facecolor())
    finally:
        plt.close(fig)
    return f"../assets/graficos/{unidad}/{nombre}"


def construir_resultado(
    *,
    titulo: str,
    etiqueta: str,
    valor,
    formato: str = "numero",
    metricas: list[dict] | None = None,
    pasos: list[str] | None = None,
    interpretacion: str = "",
    tabla: dict | None = None,
    grafico_url: str | None = None,
    notas: list[str] | None = None,
) -> dict:
    return {
        "titulo": titulo,
        "resultado_principal": {
            "etiqueta": etiqueta,
            "valor": valor,
            "formato": formato,
        },
        "metricas": metricas or [],
        "pasos": pasos or [],
        "interpretacion": interpretacion,
        "tabla": tabla,
        "grafico_url": grafico_url,
        "notas": notas or [],
    }


def metrica(etiqueta: str, valor, detalle: str = "") -> dict:
    return {"etiqueta": etiqueta, "valor": str(valor), "detalle": detalle}
