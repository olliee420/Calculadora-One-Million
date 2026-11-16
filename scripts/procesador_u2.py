# -*- coding: utf-8 -*-
"""
Motor de cálculo de la Unidad 2: Análisis de Probabilidad.

Acciones:
    u2_clasica
    u2_suma_multiplicacion
    u2_bayes
    u2_variable_aleatoria
    u2_permutaciones
    u2_combinaciones
"""

from __future__ import annotations

import math
import sys

import matplotlib.pyplot as plt

from comun import (
    COLOR_BG,
    COLOR_BLUE,
    COLOR_CYAN,
    COLOR_GREEN,
    COLOR_MUTED,
    COLOR_PURPLE,
    COLOR_TEXT,
    COLOR_YELLOW,
    a_booleano,
    a_numero,
    a_probabilidad,
    a_texto,
    configurar_estilo,
    construir_resultado,
    fallo,
    fmt,
    fmt_pct,
    guardar_figura,
    leer_payload,
    metrica,
    normalizar_probabilidades,
    obtener_params,
    parsear_enteros,
    parsear_lista,
    responder,
)


# ---------------------------------------------------------------------------
# Probabilidad clásica
# ---------------------------------------------------------------------------
def _grafico_clasica(favorables: int, posibles: int, probabilidad: float) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(6.4, 4.8))
    valores = [favorables, posibles - favorables]
    etiquetas = [
        f"Favorables\n{fmt(favorables)}",
        f"No favorables\n{fmt(posibles - favorables)}",
    ]
    colores = [COLOR_GREEN, "#334155"]
    _, _, autotextos = ax.pie(
        valores,
        labels=etiquetas,
        colors=colores,
        startangle=90,
        counterclock=False,
        autopct=lambda pct: f"{pct:.1f}%" if pct > 0 else "",
        wedgeprops=dict(width=0.42, edgecolor=COLOR_BG, linewidth=2),
        textprops=dict(color=COLOR_MUTED, fontsize=10),
    )
    for autotexto in autotextos:
        autotexto.set_color(COLOR_TEXT)
        autotexto.set_fontweight("bold")
    ax.text(
        0,
        0,
        fmt_pct(probabilidad, 2),
        ha="center",
        va="center",
        fontsize=17,
        color=COLOR_GREEN,
        fontweight="bold",
    )
    ax.set_title("Distribución de casos favorables", pad=16)
    ax.axis("equal")
    return guardar_figura(fig, "u2", "clasica")


def _probabilidad_clasica(params: dict) -> dict:
    favorables = a_numero(params.get("favorables"), "casos favorables", entero=True, minimo=0)
    posibles = a_numero(params.get("posibles"), "casos posibles", entero=True, minimo=0)
    if posibles <= 0:
        fallo("Los casos posibles deben ser mayores que cero.")
    if favorables > posibles:
        fallo("Los casos favorables no pueden superar los casos posibles.")

    evento = a_texto(params.get("evento"), "el evento") or "el evento"
    probabilidad = favorables / posibles
    complemento = 1.0 - probabilidad

    if probabilidad == 0:
        interpretacion = f"El evento «{evento}» es imposible con los datos ingresados (0%)."
    elif probabilidad == 1:
        interpretacion = f"El evento «{evento}» es seguro con los datos ingresados (100%)."
    else:
        interpretacion = (
            f"La probabilidad de «{evento}» es {fmt_pct(probabilidad)}. "
            f"En promedio ocurre en {fmt(favorables)} de cada {fmt(posibles)} casos posibles."
        )

    metricas = [
        metrica("P(A)", fmt_pct(probabilidad)),
        metrica("P(Aᶜ)", fmt_pct(complemento)),
        metrica("Casos favorables", fmt(favorables)),
        metrica("Casos posibles", fmt(posibles)),
        metrica("Razón a favor", f"{fmt(favorables)} : {fmt(posibles - favorables)}"),
        metrica("Razón en contra", f"{fmt(posibles - favorables)} : {fmt(favorables)}"),
    ]

    pasos = [
        "Fórmula de Laplace: P(A) = casos favorables / casos posibles",
        f"P(A) = {fmt(favorables)} / {fmt(posibles)} = {fmt(probabilidad, 8)}",
        f"P(A) = {fmt_pct(probabilidad)}",
        f"Complemento: P(Aᶜ) = 1 - P(A) = {fmt_pct(complemento)}",
    ]

    return construir_resultado(
        titulo="Probabilidad clásica",
        etiqueta="P(A)",
        valor=probabilidad,
        formato="porcentaje",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        grafico_url=_grafico_clasica(int(favorables), int(posibles), probabilidad),
    )


# ---------------------------------------------------------------------------
# Principio de la suma y de la multiplicación (Técnicas de conteo)
# ---------------------------------------------------------------------------
def _grafico_conteo_etapas(
    etiquetas: list[str], valores: list[int], total: int, es_suma: bool
) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(7.6, 4.2))
    paleta = [COLOR_GREEN, COLOR_CYAN, COLOR_YELLOW, COLOR_BLUE]
    colores = [paleta[i % len(paleta)] for i in range(len(valores))]

    barras = ax.bar(etiquetas, valores, color=colores, edgecolor=COLOR_BG, linewidth=1.5)
    max_val = max(valores) if valores else 1

    for barra, valor in zip(barras, valores):
        ax.text(
            barra.get_x() + barra.get_width() / 2,
            barra.get_height() + max_val * 0.025,
            f"{valor:,}",
            ha="center",
            va="bottom",
            fontsize=10,
            color=COLOR_TEXT,
            fontweight="bold",
        )

    ax.set_ylim(0, max_val * 1.2)
    ax.set_ylabel("Maneras u opciones")
    operacion_txt = "Suma (m + n)" if es_suma else "Multiplicación (m × n)"
    ax.set_title(f"{operacion_txt} — Total: {total:,} maneras", pad=14)
    ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)
    if len(etiquetas) > 4:
        plt.setp(ax.get_xticklabels(), rotation=15, ha="right")

    prefijo = "suma" if es_suma else "multiplicacion"
    return guardar_figura(fig, "u2", prefijo)


def _suma_multiplicacion(params: dict) -> dict:
    modo = a_texto(params.get("modo"), "multiplicacion").lower()
    if modo not in {"suma", "multiplicacion"}:
        fallo("El modo debe ser 'suma' o 'multiplicacion'.")

    try:
        m = int(params.get("m", 0))
        n = int(params.get("n", 0))
    except (ValueError, TypeError):
        fallo("Los valores de 'm' y 'n' deben ser números enteros.")

    if m < 1 or n < 1:
        fallo("Las cantidades de maneras 'm' y 'n' deben ser mayores o iguales a 1.")

    etapas = [m, n]
    etiquetas = ["Evento A (m)", "Evento B (n)"]

    casilleros_raw = a_texto(params.get("casilleros"), "").strip()
    if casilleros_raw:
        partes = [p.strip() for p in casilleros_raw.split(",") if p.strip() != ""]
        for idx, parte in enumerate(partes, start=3):
            try:
                val = int(parte)
            except ValueError:
                fallo(f"El casillero '{parte}' no es un número entero válido.")
            if val < 1:
                fallo("Todos los casilleros extra deben ser mayores o iguales a 1.")
            etapas.append(val)
            etiquetas.append(f"Casillero {idx}")

    if len(etapas) > 20:
        fallo("Se permite un máximo de 20 etapas o casilleros.")

    es_suma = modo == "suma"

    if es_suma:
        total = sum(etapas)
        simbolo = "+"
        formula_gral = "N = m + n" if len(etapas) == 2 else "N = n₁ + n₂ + ... + nₖ"
        titulo = "Principio de la suma"
        interpretacion = (
            f"Como los eventos son mutuamente excluyentes (no pueden realizarse juntos), "
            f"existen {total:,} maneras diferentes de realizar una opción u otra."
        )
    else:
        total = math.prod(etapas)
        simbolo = "×"
        formula_gral = "N = m × n" if len(etapas) == 2 else "N = n₁ × n₂ × ... × nₖ"
        titulo = "Principio de la Multiplicación"
        interpretacion = (
            f"Como los sucesos ocurren de forma sucesiva o independiente, "
            f"existen {total:,} maneras distintas en que pueden suceder en conjunto."
        )

    operacion_desarrollada = f" {simbolo} ".join(f"{v:,}" for v in etapas)

    metricas = [
        metrica("Maneras A (m)", f"{m:,}"),
        metrica("Maneras B (n)", f"{n:,}"),
        metrica("Total de etapas", str(len(etapas))),
        metrica("Total de maneras (N)", f"{total:,}"),
    ]

    pasos = [
        f"Fórmula: {formula_gral}",
        f"Datos: {', '.join(f'{etiq} = {val:,}' for etiq, val in zip(etiquetas, etapas))}",
        f"Sustitución: N = {operacion_desarrollada}",
        f"N = {total:,} maneras diferentes",
    ]

    return construir_resultado(
        titulo=titulo,
        etiqueta="Total de maneras (N)",
        valor=total,
        formato="entero",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        grafico_url=_grafico_conteo_etapas(etiquetas, etapas, total, es_suma),
    )


# ---------------------------------------------------------------------------
# Teorema de Bayes (Binario y Múltiples Hipótesis)
# ---------------------------------------------------------------------------
def _grafico_bayes_multiple(
    nombres: list[str],
    contribuciones: list[float],
    posteriores: list[float],
) -> str:
    configurar_estilo()
    fig, (ax1, ax2) = plt.subplots(1, 2, figsize=(12.4, 4.6))
    paleta = [COLOR_GREEN, COLOR_CYAN, COLOR_YELLOW, COLOR_BLUE, "#a855f7", "#f43f5e"]
    colores = [paleta[i % len(paleta)] for i in range(len(nombres))]

    acumulado = 0.0
    for nombre, contrib, color in zip(nombres, contribuciones, colores):
        ax1.barh(
            ["P(B)"],
            [contrib],
            left=[acumulado],
            color=color,
            edgecolor=COLOR_BG,
            label=nombre,
        )
        acumulado += contrib

    ax1.set_xlim(0, max(acumulado, 1e-9))
    ax1.set_xlabel("Contribución a P(B)")
    ax1.set_title("Componentes de la evidencia", pad=14)
    ax1.legend(loc="upper center", bbox_to_anchor=(0.5, -0.22), ncol=min(len(nombres), 3))

    etiquetas_dona = [f"{n}\n{fmt_pct(p, 2)}" for n, p in zip(nombres, posteriores)]
    ax2.pie(
        posteriores,
        labels=etiquetas_dona,
        colors=colores,
        startangle=90,
        counterclock=False,
        autopct=lambda pct: f"{pct:.1f}%" if pct >= 4 else "",
        wedgeprops=dict(width=0.42, edgecolor=COLOR_BG, linewidth=2),
        textprops=dict(color=COLOR_MUTED, fontsize=9),
    )
    ax2.text(
        0,
        0,
        fmt_pct(posteriores[0], 2),
        ha="center",
        va="center",
        fontsize=15,
        color=COLOR_GREEN,
        fontweight="bold",
    )
    ax2.set_title("Probabilidades posteriores", pad=14)
    ax2.axis("equal")
    return guardar_figura(fig, "u2", "bayes")


def _bayes(params: dict) -> dict:
    modo = a_texto(params.get("modo"), "binario").lower()

    # -----------------------------------------------------------------------
    # MODO MÚLTIPLE (k hipótesis: P1, P2, ..., Pk)
    # -----------------------------------------------------------------------
    if modo == "multiple":
        raw_nombres = a_texto(params.get("nombres"), "")
        nombres = [n.strip() for n in raw_nombres.split(",") if n.strip()]

        raw_previas = a_texto(params.get("previas"), "")
        raw_cond = a_texto(params.get("condicionales"), "")

        try:
            previas = [float(x.strip()) for x in raw_previas.split(",") if x.strip()]
            condicionales = [float(x.strip()) for x in raw_cond.split(",") if x.strip()]
        except ValueError:
            fallo("Las probabilidades previas y condicionales deben ser números válidos separados por comas.")

        if len(previas) < 2:
            fallo("Debes ingresar al menos 2 probabilidades previas separadas por comas.")
        if len(previas) != len(condicionales):
            fallo("Debe haber la misma cantidad de probabilidades previas y condicionales.")

        if len(nombres) != len(previas):
            nombres = [f"P{i + 1}" for i in range(len(previas))]

        for i, (pr, co) in enumerate(zip(previas, condicionales)):
            if not (0.0 <= pr <= 1.0) or not (0.0 <= co <= 1.0):
                fallo(f"Todas las probabilidades deben estar entre 0 y 1 (revisa el evento {nombres[i]}).")

        suma_previas = sum(previas)
        if abs(suma_previas - 1.0) > 0.005:
            fallo(f"La suma de las probabilidades previas debe ser 1.00 (100%). Actualmente suman {fmt(suma_previas, 4)}.")

        conjuntas = [pr * co for pr, co in zip(previas, condicionales)]
        p_b = sum(conjuntas)
        if p_b <= 0:
            fallo("La probabilidad total de la evidencia P(B) es cero; no se puede aplicar Bayes.")

        posteriores = [cj / p_b for cj in conjuntas]

        filas = []
        metricas = [metrica("P(B) total", fmt_pct(p_b))]
        pasos = [
            "Fórmula general: P(Aᵢ | B) = [P(B | Aᵢ) · P(Aᵢ)] / Σ [P(B | Aⱼ) · P(Aⱼ)]",
            f"Denominador P(B) = {' + '.join(f'({fmt(co)} · {fmt(pr)})' for co, pr in zip(condicionales, previas))} = {fmt(p_b, 6)}",
        ]

        for nombre, pr, co, cj, post in zip(nombres, previas, condicionales, conjuntas, posteriores):
            filas.append([
                nombre,
                fmt_pct(pr),
                fmt_pct(co),
                fmt_pct(cj),
                fmt_pct(post),
            ])
            metricas.append(metrica(f"P({nombre} | B)", fmt_pct(post)))
            pasos.append(
                f"P({nombre} | B) = ({fmt(co)} · {fmt(pr)}) / {fmt(p_b, 6)} = {fmt(cj, 6)} / {fmt(p_b, 6)} = {fmt(post, 6)} ({fmt_pct(post)})"
            )

        filas.append(["Total", "100%", "—", fmt_pct(p_b), "100%"])

        tabla = {
            "columnas": [
                "Evento (Hipótesis)",
                "Prob. previa",
                "Prob. condicional",
                "Prob. conjunta",
                "Prob. posterior",
            ],
            "filas": filas,
        }

        resumen_post = ", ".join(f"{n}: {fmt_pct(p)}" for n, p in zip(nombres, posteriores))
        interpretacion = (
            f"Con una probabilidad total de evidencia P(B) = {fmt_pct(p_b)}, las probabilidades "
            f"posteriores actualizadas son: {resumen_post}."
        )

        return construir_resultado(
            titulo="Teorema de Bayes (Múltiples Hipótesis)",
            etiqueta=f"P({nombres[0]} | B)",
            valor=posteriores[0],
            formato="porcentaje",
            metricas=metricas,
            pasos=pasos,
            interpretacion=interpretacion,
            tabla=tabla,
            grafico_url=_grafico_bayes_multiple(nombres, conjuntas, posteriores),
        )

    # -----------------------------------------------------------------------
    # MODO BINARIO (2 hipótesis: A y Aᶜ)
    # -----------------------------------------------------------------------
    p_a = a_probabilidad(params.get("p_a"), "P(A) previa")
    p_b_dado_a = a_probabilidad(params.get("p_b_dado_a"), "P(B | A)")
    p_b_dado_no_a = a_probabilidad(params.get("p_b_dado_no_a"), "P(B | Aᶜ)")
    nombre_a = a_texto(params.get("nombre_a"), "A") or "A"
    nombre_no_a = a_texto(params.get("nombre_no_a"), "Aᶜ") or "Aᶜ"

    p_no_a = 1.0 - p_a
    contribucion_a = p_a * p_b_dado_a
    contribucion_no_a = p_no_a * p_b_dado_no_a
    p_b = contribucion_a + contribucion_no_a
    if p_b <= 0:
        fallo("La probabilidad total P(B) es cero; no se puede aplicar el teorema de Bayes.")

    posterior = contribucion_a / p_b
    posterior_no_a = 1.0 - posterior

    tabla = {
        "columnas": [
            "Hipótesis",
            "Prob. previa",
            "Verosimilitud",
            "Prob. conjunta",
            "Prob. posterior",
        ],
        "filas": [
            [
                nombre_a,
                fmt_pct(p_a),
                fmt_pct(p_b_dado_a),
                fmt_pct(contribucion_a),
                fmt_pct(posterior),
            ],
            [
                nombre_no_a,
                fmt_pct(p_no_a),
                fmt_pct(p_b_dado_no_a),
                fmt_pct(contribucion_no_a),
                fmt_pct(posterior_no_a),
            ],
            ["Total", "100%", "—", fmt_pct(p_b), "100%"],
        ],
    }

    metricas = [
        metrica("P(A) previa", fmt_pct(p_a)),
        metrica("P(B | A)", fmt_pct(p_b_dado_a)),
        metrica("P(B | Aᶜ)", fmt_pct(p_b_dado_no_a)),
        metrica("P(B) total", fmt_pct(p_b)),
        metrica(f"P({nombre_a} | B)", fmt_pct(posterior)),
        metrica(f"P({nombre_no_a} | B)", fmt_pct(posterior_no_a)),
    ]

    pasos = [
        f"Probabilidades previas: P({nombre_a}) = {fmt_pct(p_a)} y P({nombre_no_a}) = {fmt_pct(p_no_a)}",
        f"Verosimilitudes: P(B | {nombre_a}) = {fmt_pct(p_b_dado_a)} y P(B | {nombre_no_a}) = {fmt_pct(p_b_dado_no_a)}",
        f"P(B) = P(B | {nombre_a})·P({nombre_a}) + P(B | {nombre_no_a})·P({nombre_no_a})",
        f"P(B) = ({fmt(p_b_dado_a)} · {fmt(p_a)}) + ({fmt(p_b_dado_no_a)} · {fmt(p_no_a)}) = {fmt(p_b, 8)}",
        f"P({nombre_a} | B) = [P(B | {nombre_a}) · P({nombre_a})] / P(B)",
        f"P({nombre_a} | B) = {fmt(contribucion_a, 8)} / {fmt(p_b, 8)} = {fmt(posterior, 8)}",
        f"P({nombre_a} | B) = {fmt_pct(posterior)}",
    ]

    interpretacion = (
        f"Después de observar el evento B, la probabilidad de {nombre_a} pasó de "
        f"{fmt_pct(p_a)} (previa) a {fmt_pct(posterior)} (posterior)."
    )

    return construir_resultado(
        titulo="Teorema de Bayes",
        etiqueta=f"P({nombre_a} | B)",
        valor=posterior,
        formato="porcentaje",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_bayes_multiple(
            [nombre_a, nombre_no_a],
            [contribucion_a, contribucion_no_a],
            [posterior, posterior_no_a],
        ),
    )


# ---------------------------------------------------------------------------
# Permutaciones
# ---------------------------------------------------------------------------
def _permutaciones(params: dict) -> dict:
    variante = a_texto(params.get("variante"), "sin_repeticion").lower()
    n = int(a_numero(params.get("n"), "n", entero=True, minimo=0, maximo=200))

    if variante == "sin_repeticion":
        r = int(a_numero(params.get("r"), "r", entero=True, minimo=0, maximo=200))
        if r > n:
            fallo("En permutaciones sin repetición, r no puede ser mayor que n.")
        resultado = math.perm(n, r)
        formula = "P_r^n = n! / (n - r)! ; r ≤ n"
        sustitucion = f"P_{r}^{n} = {n}! / ({n} - {r})!"

        pasos = [
            f"Fórmula: {formula}",
            f"Sustitución: {sustitucion}",
            f"{n}! = {math.factorial(n) if n <= 50 else 'valor exacto calculado'}",
            f"({n - r})! = {math.factorial(n - r) if n <= 50 else 'valor exacto calculado'}",
            f"Resultado: P({n}, {r}) = {resultado}",
        ]
        interpretacion = (
            f"Existen {resultado} formas distintas de ordenar {r} elementos "
            f"seleccionados de un conjunto de {n} elementos sin repetir."
        )
        etiqueta = f"P({n}, {r})"
        metricas = [
            metrica("n", fmt(n)),
            metrica("r", fmt(r)),
            metrica("Variante", "Sin repetición"),
            metrica("Resultado", fmt(resultado)),
        ]
    elif variante == "con_repeticion":
        r = int(a_numero(params.get("r"), "r", entero=True, minimo=0, maximo=200))
        resultado = n ** r
        formula = "P(n, r) = n^r"
        sustitucion = f"P({n}, {r}) = {n}^{r}"
        pasos = [
            f"Fórmula: {formula}",
            f"Sustitución: {sustitucion}",
            f"Resultado: {n}^{r} = {resultado}",
        ]
        interpretacion = (
            f"Existen {resultado} formas distintas de ordenar {r} posiciones "
            f"eligiendo entre {n} elementos, permitiendo repetición."
        )
        etiqueta = f"P({n}, {r}) con repetición"
        metricas = [
            metrica("n", fmt(n)),
            metrica("r", fmt(r)),
            metrica("Variante", "Con repetición (n^r)"),
            metrica("Resultado", fmt(resultado)),
        ]
    elif variante == "circular":
        if n < 1:
            fallo("Para permutaciones circulares, n debe ser al menos 1.")
        resultado = math.factorial(n - 1)
        formula = "P_c(n) = (n - 1)!"
        sustitucion = f"P_c({n}) = ({n} - 1)! = {n - 1}!"
        pasos = [
            f"Fórmula: {formula}",
            f"Sustitución: {sustitucion}",
            f"Resultado: {resultado}",
        ]
        interpretacion = (
            f"Existen {resultado} formas distintas de ordenar {n} elementos en un círculo, "
            "considerando que las rotaciones del mismo arreglo son equivalentes."
        )
        etiqueta = f"P_c({n})"
        metricas = [
            metrica("n", fmt(n)),
            metrica("Variante", "Circular"),
            metrica("Resultado", fmt(resultado)),
        ]
    elif variante == "elementos_repetidos":
        grupos = parsear_enteros(params.get("grupos"), "grupos de elementos repetidos")
        if any(g <= 0 for g in grupos):
            fallo("Cada grupo de elementos repetidos debe ser un entero positivo.")
        suma_grupos = sum(grupos)
        if suma_grupos != n:
            fallo(
                f"La suma de los grupos ({suma_grupos}) debe ser igual a n ({n})."
            )
        denominador = 1
        for grupo in grupos:
            denominador *= math.factorial(grupo)
        resultado = math.factorial(n) // denominador
        formula = "P = n! / (n1! · n2! · ... · nk!)"
        grupos_texto = " · ".join(f"{g}!" for g in grupos)
        sustitucion = f"P = {n}! / ({grupos_texto})"
        pasos = [
            f"Fórmula: {formula}",
            f"Sustitución: {sustitucion}",
            f"Resultado: {resultado}",
        ]
        interpretacion = (
            f"Existen {resultado} ordenamientos distintos de {n} elementos "
            f"cuando se repiten según los grupos {', '.join(map(str, grupos))}."
        )
        etiqueta = f"P({n} elementos con repetición)"
        metricas = [
            metrica("n", fmt(n)),
            metrica("Grupos", ", ".join(map(str, grupos))),
            metrica("Variante", "Elementos repetidos"),
            metrica("Resultado", fmt(resultado)),
        ]
    else:
        fallo("Variante de permutación no reconocida.")

    return construir_resultado(
        titulo="Permutaciones",
        etiqueta=etiqueta,
        valor=str(resultado),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
    )


# ---------------------------------------------------------------------------
# Combinaciones
# ---------------------------------------------------------------------------
def _combinaciones(params: dict) -> dict:
    variante = a_texto(params.get("variante"), "sin_repeticion").lower()
    n = int(a_numero(params.get("n"), "n", entero=True, minimo=0, maximo=200))
    r = int(a_numero(params.get("r"), "r", entero=True, minimo=0, maximo=200))

    if variante == "sin_repeticion":
        if r > n:
            fallo("En combinaciones sin repetición, r no puede ser mayor que n.")
        resultado = math.comb(n, r)
        formula = "C(n, r) = n! / (r! · (n - r)!)"
        sustitucion = f"C({n}, {r}) = {n}! / ({r}! · ({n} - {r})!)"
        pasos = [
            f"Fórmula: {formula}",
            f"Sustitución: {sustitucion}",
            f"{n}! = {math.factorial(n) if n <= 50 else 'valor exacto calculado'}",
            f"{r}! = {math.factorial(r) if r <= 50 else 'valor exacto calculado'}",
            f"({n - r})! = {math.factorial(n - r) if (n - r) <= 50 else 'valor exacto calculado'}",
            f"Resultado: C({n}, {r}) = {resultado}",
        ]
        interpretacion = (
            f"Existen {resultado} subconjuntos distintos de {r} elementos "
            f"que se pueden formar a partir de {n} elementos, sin importar el orden."
        )
        etiqueta = f"C({n}, {r})"
        metricas = [
            metrica("n", fmt(n)),
            metrica("r", fmt(r)),
            metrica("Variante", "Sin repetición"),
            metrica("Resultado", fmt(resultado)),
        ]
    elif variante == "con_repeticion":
        if n < 1:
            fallo("Para combinaciones con repetición, n debe ser al menos 1.")
        resultado = math.comb(n + r - 1, r)
        formula = "C(n + r - 1, r) = (n + r - 1)! / (r! · (n - 1)!)"
        sustitucion = (
            f"C({n} + {r} - 1, {r}) = C({n + r - 1}, {r})"
        )
        pasos = [
            f"Fórmula: {formula}",
            f"Sustitución: {sustitucion}",
            f"Resultado: C({n + r - 1}, {r}) = {resultado}",
        ]
        interpretacion = (
            f"Existen {resultado} formas de elegir {r} elementos de {n} tipos "
            "permitiendo repetición y sin importar el orden."
        )
        etiqueta = f"C({n} + {r} - 1, {r})"
        metricas = [
            metrica("n", fmt(n)),
            metrica("r", fmt(r)),
            metrica("Variante", "Con repetición"),
            metrica("Resultado", fmt(resultado)),
        ]
    else:
        fallo("Variante de combinación no reconocida.")

    return construir_resultado(
        titulo="Combinaciones",
        etiqueta=etiqueta,
        valor=str(resultado),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
    )


# ---------------------------------------------------------------------------
# Probabilidad Condicional (Directa y Tabla de Intersecciones 2x2)
# ---------------------------------------------------------------------------
def _grafico_condicional(etiquetas: list[str], valores: list[float], colores: list[str], titulo: str) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(7.6, 4.3))
    barras = ax.bar(etiquetas, valores, color=colores, edgecolor=COLOR_BG, linewidth=1.5)

    for barra, valor in zip(barras, valores):
        ax.text(
            barra.get_x() + barra.get_width() / 2,
            barra.get_height() + 0.02,
            fmt_pct(valor, 2),
            ha="center",
            va="bottom",
            fontsize=10,
            color=COLOR_TEXT,
            fontweight="bold",
        )

    ax.set_ylim(0, min(1.15, max(valores) + 0.20))
    ax.set_ylabel("Probabilidad")
    ax.set_title(titulo, pad=14)
    ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)
    if len(etiquetas) > 3:
        plt.setp(ax.get_xticklabels(), rotation=12, ha="right")

    return guardar_figura(fig, "u2", "condicional")


def _probabilidad_condicional(params: dict) -> dict:
    modo = a_texto(params.get("modo"), "tabla").lower()
    if modo not in {"tabla", "directo"}:
        fallo("El modo de cálculo debe ser 'tabla' o 'directo'.")

    # -----------------------------------------------------------------------
    # MODO 1: Fórmula directa P(B | A) o P(A | B)
    # -----------------------------------------------------------------------
    if modo == "directo":
        direccion = a_texto(params.get("direccion"), "b_dado_a").lower()
        p_inter = a_probabilidad(params.get("p_interseccion"), "P(A ∩ B)")
        nombre_dado = "P(A)" if direccion == "b_dado_a" else "P(B)"
        p_dado = a_probabilidad(params.get("p_condicion"), nombre_dado)

        if p_dado <= 0:
            fallo(f"La probabilidad del evento dado {nombre_dado} debe ser mayor que 0.")
        if p_inter > p_dado + 1e-9:
            fallo(f"P(A ∩ B) no puede ser mayor que {nombre_dado}.")

        p_cond = min(p_inter / p_dado, 1.0)
        p_dado_comp = max(1.0 - p_dado, 0.0)
        etiqueta_res = "P(B | A)" if direccion == "b_dado_a" else "P(A | B)"
        etiqueta_comp = "P(Aᶜ)" if direccion == "b_dado_a" else "P(Bᶜ)"

        metricas = [
            metrica("Intersección P(A ∩ B)", fmt_pct(p_inter)),
            metrica(f"Evento dado {nombre_dado}", fmt_pct(p_dado)),
            metrica(f"Complemento {etiqueta_comp}", fmt_pct(p_dado_comp)),
            metrica(etiqueta_res, fmt_pct(p_cond)),
        ]

        pasos = [
            f"Fórmula: {etiqueta_res} = P(A ∩ B) / {nombre_dado}",
            f"Complemento del evento dado: {etiqueta_comp} = 1 - {fmt(p_dado)} = {fmt(p_dado_comp)}",
            f"Sustitución: {etiqueta_res} = {fmt(p_inter)} / {fmt(p_dado)} = {fmt(p_cond, 6)}",
            f"{etiqueta_res} = {fmt_pct(p_cond)}",
        ]

        interpretacion = (
            f"Sabiendo que ya ocurrió el evento condicionante ({nombre_dado} = {fmt_pct(p_dado)}), "
            f"la probabilidad condicional {etiqueta_res} es de {fmt_pct(p_cond)}."
        )

        return construir_resultado(
            titulo="Probabilidad Condicional (Cálculo Directo)",
            etiqueta=etiqueta_res,
            valor=p_cond,
            formato="porcentaje",
            metricas=metricas,
            pasos=pasos,
            interpretacion=interpretacion,
            grafico_url=_grafico_condicional(
                ["P(A ∩ B)", nombre_dado, etiqueta_res],
                [p_inter, p_dado, p_cond],
                [COLOR_YELLOW, COLOR_CYAN, COLOR_GREEN],
                f"Comparación de {etiqueta_res}",
            ),
        )

    # -----------------------------------------------------------------------
    # MODO 2: Tabla de intersecciones y complementos (Estilo ejercicio del clima)
    # -----------------------------------------------------------------------
    p_ab = a_probabilidad(params.get("p_ab"), "P(A ∩ B)")
    p_ab_comp = a_probabilidad(params.get("p_ab_comp"), "P(A ∩ Bᶜ)")
    p_a_comp_b = a_probabilidad(params.get("p_a_comp_b"), "P(Aᶜ ∩ B)")
    p_a_comp_b_comp = a_probabilidad(params.get("p_a_comp_b_comp"), "P(Aᶜ ∩ Bᶜ)")

    suma_total = p_ab + p_ab_comp + p_a_comp_b + p_a_comp_b_comp
    if abs(suma_total - 1.0) > 0.005:
        fallo(
            f"La suma de las 4 intersecciones debe ser 1.00 (100% del espacio muestral). "
            f"Actualmente suman {fmt(suma_total, 4)}."
        )

    # Probabilidades marginales
    p_a = p_ab + p_ab_comp
    p_a_comp = p_a_comp_b + p_a_comp_b_comp
    p_b = p_ab + p_a_comp_b
    p_b_comp = p_ab_comp + p_a_comp_b_comp

    if p_a <= 0 or p_a_comp <= 0:
        fallo("Tanto P(A) como P(Aᶜ) deben ser mayores que 0 para calcular las condicionales con complemento.")

    # Condicionales (Incisos a y b de tus apuntes + inversas)
    p_b_dado_a = min(p_ab / p_a, 1.0)
    p_b_dado_a_comp = min(p_a_comp_b / p_a_comp, 1.0)
    p_a_dado_b = min(p_ab / p_b, 1.0) if p_b > 0 else 0.0

    # Verificar independencia
    es_independiente = abs(p_b_dado_a - p_b) < 1e-4
    relacion_txt = (
        "Son independientes (P(B | A) = P(B))."
        if es_independiente
        else f"Son dependientes: la ocurrencia de A cambia P(B) de {fmt_pct(p_b)} a {fmt_pct(p_b_dado_a)}."
    )

    metricas = [
        metrica("Marginal P(A)", fmt_pct(p_a)),
        metrica("Complemento P(Aᶜ)", fmt_pct(p_a_comp)),
        metrica("Marginal P(B)", fmt_pct(p_b)),
        metrica("a) P(B | A)", fmt_pct(p_b_dado_a)),
        metrica("b) P(B | Aᶜ)", fmt_pct(p_b_dado_a_comp)),
        metrica("Inversa P(A | B)", fmt_pct(p_a_dado_b)),
    ]

    pasos = [
        f"Marginales de A: P(A) = {fmt(p_ab)} + {fmt(p_ab_comp)} = {fmt(p_a)} | P(Aᶜ) = {fmt(p_a_comp_b)} + {fmt(p_a_comp_b_comp)} = {fmt(p_a_comp)}",
        f"Marginal de B: P(B) = {fmt(p_ab)} + {fmt(p_a_comp_b)} = {fmt(p_b)}",
        f"a) P(B | A) = P(A ∩ B) / P(A) = {fmt(p_ab)} / {fmt(p_a)} = {fmt(p_b_dado_a, 6)} ({fmt_pct(p_b_dado_a)})",
        f"b) P(B | Aᶜ) = P(Aᶜ ∩ B) / P(Aᶜ) = {fmt(p_a_comp_b)} / {fmt(p_a_comp)} = {fmt(p_b_dado_a_comp, 6)} ({fmt_pct(p_b_dado_a_comp)})",
    ]

    interpretacion = (
        f"Dado que ocurre A, la probabilidad de B es {fmt_pct(p_b_dado_a)}; mientras que si ocurre su complemento Aᶜ, "
        f"baja/cambia a {fmt_pct(p_b_dado_a_comp)}. {relacion_txt}"
    )

    return construir_resultado(
        titulo="Probabilidad Condicional (Tabla de Intersecciones)",
        etiqueta="a) P(B | A)",
        valor=p_b_dado_a,
        formato="porcentaje",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        grafico_url=_grafico_condicional(
            ["General P(B)", "a) P(B | A)", "b) P(B | Aᶜ)", "Inversa P(A | B)"],
            [p_b, p_b_dado_a, p_b_dado_a_comp, p_a_dado_b],
            [COLOR_BLUE, COLOR_GREEN, COLOR_YELLOW, COLOR_CYAN],
            "Probabilidad general vs. Probabilidades condicionales",
        ),
    )


# ---------------------------------------------------------------------------
# Enrutador CLI
# ---------------------------------------------------------------------------
ACCIONES = {
    "u2_clasica": _probabilidad_clasica,
    "u2_suma_multiplicacion": _suma_multiplicacion,
    "u2_bayes": _bayes,
    "u2_permutaciones": _permutaciones,
    "u2_combinaciones": _combinaciones,
    "u2_probabilidad_condicional": _probabilidad_condicional,

}


def main() -> None:
    payload = leer_payload()
    accion = a_texto(payload.get("action"))
    manejador = ACCIONES.get(accion)
    if manejador is None:
        fallo(f"Acción no reconocida por el procesador de la Unidad 2: {accion}")

    params = obtener_params(payload)
    try:
        resultado = manejador(params)
    except SystemExit:
        raise
    except Exception as exc:  # pragma: no cover - salvaguarda para el servidor
        import traceback

        traceback.print_exc(file=sys.stderr)
        fallo(f"Error interno del motor de la Unidad 2: {exc}")

    responder({"ok": True, "resultado": resultado})


if __name__ == "__main__":
    main()


