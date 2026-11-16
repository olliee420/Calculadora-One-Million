from __future__ import annotations

import sys
import math
from comun import (
    configurar_estilo,
    guardar_figura,
    fallo,
    responder,
    leer_payload,
    obtener_params,
    metrica,
    construir_resultado,
    parsear_enteros,
    a_numero,
    a_probabilidad,
    fmt,
    fmt_pct,
    COLOR_CYAN,
    COLOR_GREEN,
    COLOR_YELLOW,
    COLOR_BG,
    COLOR_TEXT,
)
import matplotlib.pyplot as plt


# ---------------------------------------------------------------------------
# 1. Clasificación y análisis de Variable Aleatoria (Discretas y Continuas)
# ---------------------------------------------------------------------------
def _grafico_variable_aleatoria(
    etiquetas: list[str], frecuencias: list[int], es_cuantitativa: bool, nombre: str
) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    color_barra = COLOR_CYAN if es_cuantitativa else COLOR_GREEN
    posiciones = list(range(len(etiquetas)))

    barras = ax.bar(
        posiciones,
        frecuencias,
        width=0.58,
        color=color_barra,
        alpha=0.85,
        edgecolor=COLOR_BG,
        linewidth=1.2,
    )

    total = sum(frecuencias)
    for barra, freq in zip(barras, frecuencias):
        pct = (freq / total) * 100 if total > 0 else 0
        ax.text(
            barra.get_x() + barra.get_width() / 2,
            freq + (max(frecuencias) * 0.025),
            f"{freq} ({pct:.1f}%)",
            ha="center",
            va="bottom",
            fontsize=9.5,
            color=COLOR_TEXT,
        )

    ax.set_xticks(posiciones)
    ax.set_xticklabels(etiquetas, rotation=15 if len(etiquetas) > 5 else 0)
    ax.set_xlabel("Valores / Categorías observadas")
    ax.set_ylabel("Frecuencia absoluta")
    ax.set_title(f"Distribución de frecuencias: {nombre}", pad=14)
    ax.set_ylim(0, max(frecuencias) * 1.18 if frecuencias else 1)

    return guardar_figura(fig, "u3", "variable")


def _variable_aleatoria(params: dict) -> dict:
    raw_datos = params.get("datos")
    if raw_datos is None or str(raw_datos).strip() == "":
        fallo("Debes ingresar al menos un dato observado separado por comas.")

    items = [x.strip() for x in str(raw_datos).split(",") if x.strip() != ""]
    if not items:
        fallo("No se encontraron datos válidos separados por comas.")

    nombre = str(params.get("nombre_variable") or "").strip() or "Variable analizada"
    tiene_orden = str(params.get("tiene_orden") or "auto").strip().lower()

    numeros = []
    es_cuantitativa = True
    for item in items:
        try:
            numeros.append(float(item))
        except ValueError:
            es_cuantitativa = False
            break

    notas = []
    if es_cuantitativa:
        grupo = "Cuantitativa (Métrica)"
        if all(n.is_integer() for n in numeros):
            subtipo = "Discreta"
            criterio = "Valores enteros y contables de forma exacta; no admiten decimales intermedios."
        else:
            subtipo = "Continua"
            criterio = "Pueden tomar cualquier valor numérico (entero o fraccionario/decimal) dentro de un intervalo."

        if tiene_orden in ("si", "no"):
            notas.append(
                "Al tratarse de valores numéricos aritméticos, se clasificó automáticamente como Cuantitativa."
            )
    else:
        grupo = "Cualitativa (No métrica)"
        escalas_ordinales = {
            "bajo", "medio", "alto",
            "malo", "regular", "bueno", "excelente",
            "pesimo", "pésimo", "deficiente", "sobresaliente",
            "primaria", "secundaria", "bachillerato", "universidad", "posgrado",
            "primero", "segundo", "tercero",
        }
        items_lower = {i.lower() for i in items}
        coincidencias_orden = len(items_lower & escalas_ordinales)

        if tiene_orden == "si" or (tiene_orden == "auto" and coincidencias_orden >= 2):
            subtipo = "Ordinal"
            criterio = "Categorías descritas con palabras bajo un orden de supremacía o jerarquía, sin cuantificar diferencia exacta."
            if tiene_orden == "auto":
                notas.append("Se detectó jerarquía natural automáticamente a partir de las categorías ingresadas.")
        else:
            subtipo = "Nominal"
            criterio = "Atributos o cualidades en palabras que no se cuantifican ni poseen un orden natural implícito."

    clasificacion_completa = f"{grupo} - {subtipo}"

    conteo: dict[str, int] = {}
    if es_cuantitativa:
        for n in sorted(numeros):
            clave = fmt(n)
            conteo[clave] = conteo.get(clave, 0) + 1
    else:
        for item in items:
            conteo[item] = conteo.get(item, 0) + 1

    total_datos = len(items)
    categorias_unicas = len(conteo)
    max_freq = max(conteo.values())
    modas = [k for k, v in conteo.items() if v == max_freq]
    moda_texto = ", ".join(modas)

    filas = []
    acumulada = 0
    for categoria, freq in conteo.items():
        acumulada += freq
        relativa = freq / total_datos
        filas.append([
            categoria,
            str(freq),
            fmt_pct(relativa),
            str(acumulada),
        ])

    tabla = {
        "columnas": ["Valor / Categoría", "Frecuencia (f)", "Porcentaje (%)", "Frec. Acumulada"],
        "filas": filas,
    }

    metricas = [
        metrica("Variable", nombre),
        metrica("Grupo principal", grupo),
        metrica("Subtipo", subtipo),
        metrica("Total de datos (n)", str(total_datos)),
        metrica("Valores distintos", str(categorias_unicas)),
        metrica("Moda (más frecuente)", f"{moda_texto} ({max_freq})"),
    ]

    if es_cuantitativa:
        media = sum(numeros) / total_datos
        metricas.extend([
            metrica("Mínimo", fmt(min(numeros))),
            metrica("Máximo", fmt(max(numeros))),
            metrica("Media aritmética", fmt(media, 4)),
        ])

    pasos = [
        f"1. Datos ingresados (n = {total_datos}): {', '.join(items[:12])}{'...' if len(items) > 12 else ''}",
        f"2. Naturaleza de los datos: {'Todos son valores numéricos aritméticos' if es_cuantitativa else 'Contienen cualidades o categorías expresadas en palabras'}.",
        f"3. Grupo asignado: {grupo}.",
        f"4. Subclasificación: {subtipo} - {criterio}",
    ]

    interpretacion = (
        f"La variable '{nombre}' corresponde a una Variable {grupo} de tipo {subtipo}. "
        f"{criterio} "
        f"En la muestra de {total_datos} observaciones, la categoría o valor más frecuente es '{moda_texto}'."
    )

    return construir_resultado(
        titulo=f"Clasificación de Variable: {nombre}",
        etiqueta="Tipo de variable",
        valor=clasificacion_completa,
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_variable_aleatoria(
            list(conteo.keys()), list(conteo.values()), es_cuantitativa, nombre
        ),
        notas=notas,
    )

# ---------------------------------------------------------------------------
# 2. Distribución Binomial (Apuntes U3)
# ---------------------------------------------------------------------------
def _grafico_binomial(
    valores_k: list[int], probs: list[float], x_objetivo: int, n: int, p: float
) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    colores = [COLOR_YELLOW if k == x_objetivo else COLOR_CYAN for k in valores_k]
    barras = ax.bar(
        valores_k,
        probs,
        width=0.6,
        color=colores,
        alpha=0.88,
        edgecolor=COLOR_BG,
        linewidth=1.2,
    )

    for k, prob in zip(valores_k, probs):
        if len(valores_k) <= 15 or k == x_objetivo:
            ax.text(
                k,
                prob + (max(probs) * 0.025),
                fmt_pct(prob, 2),
                ha="center",
                va="bottom",
                fontsize=8.5,
                color=COLOR_YELLOW if k == x_objetivo else COLOR_TEXT,
                fontweight="bold" if k == x_objetivo else "normal",
            )

    ax.set_xticks(valores_k if len(valores_k) <= 20 else range(0, n + 1, max(1, n // 15)))
    ax.set_xlabel("Número de éxitos (k)")
    ax.set_ylabel("Probabilidad P(X = k)")
    ax.set_title(f"Distribución Binomial B(n={n}, p={fmt(p, 4)}) — Resaltado x={x_objetivo}", pad=14)
    ax.set_ylim(0, max(probs) * 1.2 if probs else 1)

    return guardar_figura(fig, "u3", "binomial")


def _binomial(params: dict) -> dict:
    n = int(a_numero(params.get("n"), "número de pruebas (n)", entero=True, minimo=1, maximo=200))
    x = int(a_numero(params.get("x"), "número de éxitos (x)", entero=True, minimo=0, maximo=n))
    p = a_probabilidad(params.get("p"), "probabilidad de éxito (p)")
    q = 1.0 - p

    comb = math.comb(n, x)
    prob_exacta = comb * (p ** x) * (q ** (n - x))

    valores_k = list(range(n + 1))
    probs_todas = [math.comb(n, k) * (p ** k) * (q ** (n - k)) for k in valores_k]
    prob_acumulada = sum(probs_todas[: x + 1])
    prob_mayor = 1.0 - prob_acumulada

    media = n * p
    varianza = n * p * q
    desviacion = math.sqrt(varianza)

    filas = []
    acum = 0.0
    for k, pk in zip(valores_k, probs_todas):
        acum += pk
        marca = " ◀" if k == x else ""
        filas.append([
            f"{k}{marca}",
            str(math.comb(n, k)),
            fmt(pk, 6),
            fmt_pct(pk, 2),
            fmt(acum, 6),
        ])

    tabla = {
        "columnas": ["Éxitos (k)", "C(n, k)", "P(X = k)", "Porcentaje", "Acumulada F(k)"],
        "filas": filas,
    }

    metricas = [
        metrica("P(X = x) exacta", fmt_pct(prob_exacta, 4), f"Decimal: {fmt(prob_exacta, 6)}"),
        metrica("P(X ≤ x) acumulada", fmt_pct(prob_acumulada, 4), f"Decimal: {fmt(prob_acumulada, 6)}"),
        metrica("P(X > x) mayor que x", fmt_pct(prob_mayor, 4)),
        metrica("Fracaso (q = 1 - p)", fmt(q, 6)),
        metrica("Combinaciones C(n, x)", str(comb)),
        metrica("Media (μ = n·p)", fmt(media, 4)),
        metrica("Varianza (σ² = n·p·q)", fmt(varianza, 4)),
        metrica("Desviación (σ)", fmt(desviacion, 4)),
    ]

    pasos = [
        f"1. Datos: n = {n}, x = {x}, p = {fmt(p, 6)}, q = 1 - {fmt(p, 6)} = {fmt(q, 6)}.",
        f"2. Combinaciones: C({n}, {x}) = {n}! / ({x}! · {n - x}!) = {comb}.",
        f"3. Fórmula: P(X = {x}) = {comb} · ({fmt(p, 6)})^{x} · ({fmt(q, 6)})^{n - x}.",
        f"4. Resultado puntual: P(X = {x}) = {fmt(prob_exacta, 6)} ({fmt_pct(prob_exacta, 2)}).",
        f"5. Acumulada (máximo {x} éxitos): P(X ≤ {x}) = {fmt(prob_acumulada, 6)} ({fmt_pct(prob_acumulada, 2)}).",
        f"6. Parámetros: μ = {n}·{fmt(p, 4)} = {fmt(media, 4)} | σ² = {fmt(varianza, 4)}.",
    ]

    interpretacion = (
        f"En {n} pruebas idénticas con probabilidad de éxito p = {fmt(p, 4)} (q = {fmt(q, 4)}), "
        f"la probabilidad de obtener exactamente {x} éxitos es {fmt_pct(prob_exacta, 2)} ({fmt(prob_exacta, 4)}), "
        f"mientras que la probabilidad de obtener un máximo de {x} éxitos es {fmt_pct(prob_acumulada, 2)}. "
        f"El valor esperado promedio es μ = {fmt(media, 2)} éxitos."
    )

    return construir_resultado(
        titulo=f"Distribución Binomial B(n={n}, p={fmt(p, 4)})",
        etiqueta=f"P(X = {x})",
        valor=prob_exacta,
        formato="probabilidad",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_binomial(valores_k, probs_todas, x, n, p),
    )

# ---------------------------------------------------------------------------
# 3. Distribución de Poisson (Apuntes U3)
# ---------------------------------------------------------------------------
def _grafico_poisson(
    valores_k: list[int], probs: list[float], x_objetivo: int, lam: float
) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    colores = [COLOR_YELLOW if k == x_objetivo else COLOR_CYAN for k in valores_k]
    ax.bar(
        valores_k,
        probs,
        width=0.6,
        color=colores,
        alpha=0.88,
        edgecolor=COLOR_BG,
        linewidth=1.2,
    )

    for k, prob in zip(valores_k, probs):
        if len(valores_k) <= 16 or k == x_objetivo:
            ax.text(
                k,
                prob + (max(probs) * 0.025),
                fmt_pct(prob, 1),
                ha="center",
                va="bottom",
                fontsize=8.5,
                color=COLOR_YELLOW if k == x_objetivo else COLOR_TEXT,
                fontweight="bold" if k == x_objetivo else "normal",
            )

    ax.set_xticks(valores_k if len(valores_k) <= 20 else range(0, max(valores_k) + 1, 2))
    ax.set_xlabel("Número de éxitos (k)")
    ax.set_ylabel("Probabilidad P(X = k)")
    ax.set_title(f"Distribución de Poisson (λ = {fmt(lam, 4)}) — Resaltado x = {x_objetivo}", pad=14)
    ax.set_ylim(0, max(probs) * 1.2 if probs else 1)

    return guardar_figura(fig, "u3", "poisson")


def _poisson(params: dict) -> dict:
    modo = str(params.get("modo_lambda") or "directo").strip().lower()
    x = int(a_numero(params.get("x"), "número de éxitos (x)", entero=True, minimo=0, maximo=200))

    paso_lambda = ""
    if modo == "proporcion":
        ev_base = float(a_numero(params.get("eventos_base"), "eventos conocidos", minimo=0.0001))
        int_base = float(a_numero(params.get("intervalo_base"), "intervalo base", minimo=0.0001))
        int_obj = float(a_numero(params.get("intervalo_objetivo"), "nuevo intervalo", minimo=0.0001))
        lam = (ev_base * int_obj) / int_base
        paso_lambda = (
            f"1. Cálculo de λ (Regla de tres): ({fmt(ev_base)} · {fmt(int_obj)}) / {fmt(int_base)} = {fmt(lam, 4)}."
        )
    elif modo == "binomial":
        n_b = int(a_numero(params.get("n_binom"), "tamaño de muestra (n)", entero=True, minimo=1))
        p_b = a_probabilidad(params.get("p_binom"), "probabilidad (p)")
        lam = n_b * p_b
        if lam <= 0:
            fallo("El producto λ = n · p debe ser mayor que cero.")
        paso_lambda = (
            f"1. Cálculo de λ (Aproximación Binomial): λ = {n_b} · {fmt(p_b, 6)} = {fmt(lam, 4)}."
        )
    else:
        lam = float(a_numero(params.get("lam"), "promedio de éxitos (λ)", minimo=0.0001, maximo=500))
        paso_lambda = f"1. Datos directos: λ = {fmt(lam, 4)}, x = {x}, e ≈ 2.71828."

    if lam > 500:
        fallo("El valor resultante de λ es demasiado grande (máximo permitido: 500).")

    prob_exacta = ((lam ** x) * math.exp(-lam)) / math.factorial(x)

    limite_k = max(x + 5, int(math.ceil(lam + 4 * math.sqrt(lam))))
    limite_k = min(limite_k, 60)
    valores_k = list(range(limite_k + 1))

    probs_rango = [((lam ** k) * math.exp(-lam)) / math.factorial(k) for k in valores_k]
    prob_acumulada = sum(((lam ** k) * math.exp(-lam)) / math.factorial(k) for k in range(x + 1))
    prob_mayor = max(0.0, 1.0 - prob_acumulada)
    prob_al_menos = max(0.0, 1.0 - sum(((lam ** k) * math.exp(-lam)) / math.factorial(k) for k in range(x)))

    filas = []
    acum = 0.0
    for k, pk in zip(valores_k, probs_rango):
        acum += pk
        marca = " ◀" if k == x else ""
        filas.append([
            f"{k}{marca}",
            fmt(pk, 6),
            fmt_pct(pk, 2),
            fmt(acum, 6),
        ])

    tabla = {
        "columnas": ["Éxitos (k)", "P(k / λ)", "Porcentaje", "Acumulada F(k)"],
        "filas": filas,
    }

    metricas = [
        metrica("λ (Lambda) usado", fmt(lam, 4)),
        metrica("P(X = x) exacta", fmt_pct(prob_exacta, 2), f"Decimal: {fmt(prob_exacta, 4)}"),
        metrica("P(X ≤ x) máximo x", fmt_pct(prob_acumulada, 2), f"Decimal: {fmt(prob_acumulada, 4)}"),
        metrica("P(X > x) más de x", fmt_pct(prob_mayor, 2), f"Decimal: {fmt(prob_mayor, 4)}"),
        metrica("P(X ≥ x) al menos x", fmt_pct(prob_al_menos, 2)),
        metrica("Media (μ = λ)", fmt(lam, 4)),
        metrica("Varianza (σ² = λ)", fmt(lam, 4)),
        metrica("Desviación (σ = √λ)", fmt(math.sqrt(lam), 4)),
    ]

    pasos = [
        paso_lambda,
        f"2. Fórmula: P({x} / {fmt(lam, 4)}) = ({fmt(lam, 4)}^{x} · e^−{fmt(lam, 4)}) / {x}!.",
        f"3. Resultado puntual: P(X = {x}) = {fmt(prob_exacta, 4)} ({fmt_pct(prob_exacta, 2)}).",
        f"4. Probabilidad acumulada (máximo {x}): P(X ≤ {x}) = {fmt(prob_acumulada, 4)} ({fmt_pct(prob_acumulada, 2)}).",
        f"5. Por complemento (más de {x}): P(X > {x}) = 1 − {fmt(prob_acumulada, 4)} = {fmt(prob_mayor, 4)} ({fmt_pct(prob_mayor, 2)}).",
    ]

    interpretacion = (
        f"Con un promedio esperado de λ = {fmt(lam, 4)} éxitos en el intervalo, "
        f"la probabilidad de que ocurran exactamente {x} éxitos es {fmt_pct(prob_exacta, 2)} ({fmt(prob_exacta, 4)}). "
        f"La probabilidad de obtener un máximo de {x} éxitos es {fmt_pct(prob_acumulada, 2)}, "
        f"y la de obtener más de {x} éxitos es {fmt_pct(prob_mayor, 2)}."
    )

    return construir_resultado(
        titulo=f"Distribución de Poisson (λ = {fmt(lam, 4)})",
        etiqueta=f"P({x} / {fmt(lam, 2)})",
        valor=prob_exacta,
        formato="probabilidad",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_poisson(valores_k, probs_rango, x, lam),
    )

# ---------------------------------------------------------------------------
# 4. Distribución Normal Estándar (Apuntes U3)
# ---------------------------------------------------------------------------
def _grafico_normal(mu: float, sigma: float, x_val: float, z_val: float) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    x_min = mu - 4 * sigma
    x_max = mu + 4 * sigma
    pasos = 300
    xs = [x_min + (x_max - x_min) * i / pasos for i in range(pasos + 1)]
    ys = [
        (1.0 / (sigma * math.sqrt(2.0 * math.pi)))
        * math.exp(-0.5 * (((xv - mu) / sigma) ** 2))
        for xv in xs
    ]

    ax.plot(xs, ys, color=COLOR_CYAN, linewidth=2.2, label="Curva Normal f(x)")

    # Sombrear área acumulada P(X <= x)
    xs_fill = [xv for xv in xs if xv <= x_val]
    ys_fill = [yv for xv, yv in zip(xs, ys) if xv <= x_val]
    if xs_fill:
        ax.fill_between(xs_fill, ys_fill, color=COLOR_GREEN, alpha=0.28, label="Área P(X ≤ x)")

    # Línea vertical en el punto x evaluado
    if x_min <= x_val <= x_max:
        y_punto = (1.0 / (sigma * math.sqrt(2.0 * math.pi))) * math.exp(-0.5 * (z_val ** 2))
        ax.axvline(x_val, color=COLOR_YELLOW, linestyle="--", linewidth=1.6)
        ax.scatter([x_val], [y_punto], color=COLOR_YELLOW, zorder=4, s=45)

    ax.axvline(mu, color="#64748b", linestyle=":", linewidth=1.2, label=f"Media μ = {fmt(mu, 2)}")
    ax.set_xlabel("Valores de X")
    ax.set_ylabel("Densidad de probabilidad (Y)")
    ax.set_title(f"Distribución Normal (μ = {fmt(mu, 2)}, σ = {fmt(sigma, 2)}) — Z = {fmt(z_val, 2)}", pad=14)
    ax.legend(loc="upper right")

    return guardar_figura(fig, "u3", "normal")


def _normal(params: dict) -> dict:
    mu = float(a_numero(params.get("media"), "media poblacional (μ)"))
    sigma = float(a_numero(params.get("desviacion"), "desviación estándar (σ)", minimo=0.0001))
    x_val = float(a_numero(params.get("valor_x"), "valor a evaluar (x)"))

    z_val = (x_val - mu) / sigma

    # Densidad Y según fórmula de apuntes
    densidad_y = (1.0 / (sigma * math.sqrt(2.0 * math.pi))) * math.exp(-0.5 * (z_val ** 2))

    # Probabilidad acumulada P(Z <= z) usando función error de Gauss
    prob_menor = 0.5 * (1.0 + math.erf(z_val / math.sqrt(2.0)))
    prob_mayor = 1.0 - prob_menor
    area_centro = abs(prob_menor - 0.5)

    tabla = {
        "columnas": ["Concepto", "Fórmula / Expresión", "Valor"],
        "filas": [
            ["Puntaje estándar (Z)", "(x − μ) / σ", fmt(z_val, 4)],
            ["Densidad de probabilidad (Y)", "[1 / (σ√2π)] · e^(−z²/2)", fmt(densidad_y, 6)],
            ["Área acumulada izquierda P(X ≤ x)", "P(Z ≤ z)", f"{fmt(prob_menor, 4)} ({fmt_pct(prob_menor, 2)})"],
            ["Área derecha P(X > x)", "1 − P(Z ≤ z)", f"{fmt(prob_mayor, 4)} ({fmt_pct(prob_mayor, 2)})"],
            ["Área entre media y x", "|P(Z ≤ z) − 0.5|", f"{fmt(area_centro, 4)} ({fmt_pct(area_centro, 2)})"],
        ],
    }

    metricas = [
        metrica("Puntaje Z", fmt(z_val, 4)),
        metrica("Densidad Y (altura)", fmt(densidad_y, 4)),
        metrica("P(X ≤ x) izquierda", fmt_pct(prob_menor, 2), f"Decimal: {fmt(prob_menor, 4)}"),
        metrica("P(X > x) derecha", fmt_pct(prob_mayor, 2), f"Decimal: {fmt(prob_mayor, 4)}"),
        metrica("Área desde μ hasta x", fmt_pct(area_centro, 2), f"Decimal: {fmt(area_centro, 4)}"),
        metrica("Media (μ)", fmt(mu, 4)),
        metrica("Desviación (σ)", fmt(sigma, 4)),
    ]

    pasos = [
        f"1. Datos: μ = {fmt(mu, 4)}, σ = {fmt(sigma, 4)}, x = {fmt(x_val, 4)}, π ≈ 3.14159, e ≈ 2.71828.",
        f"2. Estandarización Z: Z = ({fmt(x_val, 4)} − {fmt(mu, 4)}) / {fmt(sigma, 4)} = {fmt(z_val, 4)}.",
        f"3. Ordenada de densidad Y: Y = [1 / ({fmt(sigma, 4)}·√2π)] · e^(−({fmt(z_val, 4)})²/2) = {fmt(densidad_y, 4)}.",
        f"4. Probabilidad acumulada P(X ≤ {fmt(x_val, 4)}) = {fmt(prob_menor, 4)} ({fmt_pct(prob_menor, 2)}).",
        f"5. Área entre la media y x: {fmt(area_centro, 4)} ({fmt_pct(area_centro, 2)}).",
    ]

    interpretacion = (
        f"Para x = {fmt(x_val, 2)} en una distribución normal con μ = {fmt(mu, 2)} y σ = {fmt(sigma, 2)}, "
        f"el puntaje estandarizado es Z = {fmt(z_val, 2)} y la altura de la curva es Y = {fmt(densidad_y, 4)}. "
        f"El área acumulada a la izquierda es {fmt_pct(prob_menor, 2)} y el área comprendida entre la media y el punto es {fmt_pct(area_centro, 2)}."
    )

    return construir_resultado(
        titulo=f"Distribución Normal (μ = {fmt(mu, 2)}, σ = {fmt(sigma, 2)})",
        etiqueta=f"P(X ≤ {fmt(x_val, 2)})",
        valor=prob_menor,
        formato="probabilidad",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_normal(mu, sigma, x_val, z_val),
    )

# ---------------------------------------------------------------------------
# 5. Ajuste de la Curva Normal y Áreas bajo la Curva (Apuntes U3)
# ---------------------------------------------------------------------------
def _grafico_ajuste_curva(
    etiquetas: list[str],
    pms: list[float],
    f_reales: list[int],
    f_teoricas: list[int],
    mu: float,
    sigma: float,
    y0: float,
    ancho_i: float,
) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    ax.bar(
        pms,
        f_reales,
        width=ancho_i * 0.88,
        color=COLOR_CYAN,
        alpha=0.45,
        edgecolor=COLOR_CYAN,
        linewidth=1.3,
        label="Frecuencia real (f)",
    )

    x_min = min(pms) - ancho_i
    x_max = max(pms) + ancho_i
    xs = [x_min + (x_max - x_min) * k / 250 for k in range(251)]
    ys = [y0 * math.exp(-0.5 * (((xv - mu) / sigma) ** 2)) for xv in xs]

    ax.plot(xs, ys, color=COLOR_YELLOW, linewidth=2.3, label="Curva Normal ajustada")
    ax.scatter(pms, f_teoricas, color=COLOR_GREEN, zorder=4, s=50, label="Frecuencia teórica (F teo)")

    for pm, ft in zip(pms, f_teoricas):
        ax.text(
            pm,
            ft + (max(max(f_reales), y0) * 0.035),
            str(ft),
            ha="center",
            va="bottom",
            fontsize=9,
            color=COLOR_GREEN,
            fontweight="bold",
        )

    ax.set_xticks(pms)
    ax.set_xticklabels(etiquetas)
    ax.set_xlabel("Intervalos de clase (Marca de clase Pm)")
    ax.set_ylabel("Frecuencia (número de observaciones)")
    ax.set_title(f"Ajuste de Curva Normal (X̄ = {fmt(mu, 2)}, σ = {fmt(sigma, 2)}, Y₀ = {fmt(y0, 2)})", pad=14)
    ax.set_ylim(0, max(max(f_reales), y0) * 1.22)
    ax.legend(loc="upper right")

    return guardar_figura(fig, "u3", "ajuste_curva")


def _ajuste_frecuencias(params: dict) -> dict:
    raw_int = str(params.get("intervalos") or "").strip()
    if not raw_int:
        fallo("Debes ingresar los intervalos de clase separados por comas (Ej: 0-3, 3-6, 6-9).")

    partes = [p.strip() for p in raw_int.split(",") if p.strip()]
    if len(partes) < 3:
        fallo("Ingresa al menos 3 intervalos de clase para ajustar la curva.")

    limites: list[tuple[float, float]] = []
    etiquetas: list[str] = []
    for p in partes:
        trozos = [t.strip() for t in p.split("-") if t.strip() != ""]
        if len(trozos) != 2:
            fallo(f"Formato inválido en el intervalo '{p}'. Usa el formato Li-Ls (ejemplo: 0-3).")
        try:
            li = float(trozos[0])
            ls = float(trozos[1])
        except ValueError:
            fallo(f"Los límites de '{p}' deben ser números válidos.")
        if ls <= li:
            fallo(f"El límite superior debe ser mayor al inferior en '{p}'.")
        limites.append((li, ls))
        etiquetas.append(f"{fmt(li)} - {fmt(ls)}")

    f_reales = parsear_enteros(params.get("frecuencias"), "frecuencias reales (f)")
    if len(f_reales) != len(limites):
        fallo("La cantidad de frecuencias reales debe coincidir con la cantidad de intervalos.")
    if any(f < 0 for f in f_reales):
        fallo("Las frecuencias reales no pueden ser negativas.")

    n_total = sum(f_reales)
    if n_total <= 0:
        fallo("La suma de frecuencias reales debe ser mayor que cero.")

    pms = [(li + ls) / 2.0 for li, ls in limites]
    anchos = [ls - li for li, ls in limites]
    ancho_i = sum(anchos) / len(anchos)

    suma_pm_f = sum(pm * f for pm, f in zip(pms, f_reales))
    media = suma_pm_f / n_total
    suma_desv2_f = sum(((pm - media) ** 2) * f for pm, f in zip(pms, f_reales))
    varianza = suma_desv2_f / n_total
    sigma = math.sqrt(varianza)
    if sigma <= 0:
        fallo("La desviación estándar resultó 0; verifica las frecuencias ingresadas.")

    y0 = (n_total * ancho_i) / (sigma * math.sqrt(2.0 * math.pi))

    zs = [(pm - media) / sigma for pm in pms]
    ordenadas_rel = [math.exp(-0.5 * (z ** 2)) for z in zs]
    f_crudas = [y0 * ord_rel for ord_rel in ordenadas_rel]

    f_teoricas = [int(round(fc)) for fc in f_crudas]
    diferencia = n_total - sum(f_teoricas)
    if diferencia != 0:
        residuos = [(fc - round(fc), idx) for idx, fc in enumerate(f_crudas)]
        if diferencia > 0:
            residuos.sort(key=lambda t: t[0], reverse=True)
            for k in range(abs(diferencia)):
                idx_objetivo = residuos[k % len(residuos)][1]
                f_teoricas[idx_objetivo] += 1
        else:
            residuos.sort(key=lambda t: t[0])
            for k in range(abs(diferencia)):
                idx_objetivo = residuos[k % len(residuos)][1]
                if f_teoricas[idx_objetivo] > 0:
                    f_teoricas[idx_objetivo] -= 1

    filas = []
    for etq, pm, f_real, z, ord_rel, fc, ft in zip(
        etiquetas, pms, f_reales, zs, ordenadas_rel, f_crudas, f_teoricas
    ):
        filas.append([
            etq,
            fmt(pm, 2),
            str(f_real),
            fmt(z, 2),
            fmt(ord_rel, 5),
            fmt(fc, 2),
            str(ft),
        ])
    filas.append(["Σ Total", "—", str(n_total), "—", "—", fmt(sum(f_crudas), 2), str(sum(f_teoricas))])

    tabla = {
        "columnas": ["Clases", "Pm", "F real", "Z (X est.)", "Ordenada e^(−z²/2)", "Y teórica", "F teo (redondeada)"],
        "filas": filas,
    }

    metricas = [
        metrica("Total datos (n)", str(n_total)),
        metrica("Ancho de clase (i)", fmt(ancho_i, 2)),
        metrica("Media (X̄)", fmt(media, 2)),
        metrica("Desviación (σ)", fmt(sigma, 2)),
        metrica("Altura máxima (Y₀)", fmt(y0, 2)),
        metrica("Suma F teórica", str(sum(f_teoricas))),
    ]

    pasos = [
        f"1. Datos: n = {n_total}, ancho de intervalo i = {fmt(ancho_i, 2)}.",
        f"2. Paso 1 (Media y Desviación): X̄ = {fmt(suma_pm_f, 2)} / {n_total} = {fmt(media, 2)} | σ = √({fmt(suma_desv2_f, 2)} / {n_total}) = {fmt(sigma, 2)}.",
        f"3. Paso 2 (Altura máxima Y₀): Y₀ = ({n_total} · {fmt(ancho_i, 2)}) / ({fmt(sigma, 2)} · √2π) = {fmt(y0, 2)}.",
        "4. Paso 3 (Estandarización y Frecuencias): Se calcula Z = (Pm − X̄) / σ, se multiplica Y₀ por e^(−z²/2) y se redondea ajustando para cerrar en n.",
    ]

    notas = []
    if diferencia != 0:
        notas.append(
            f"Se aplicó ajuste convencional ({'+' if diferencia > 0 else ''}{diferencia}) en la clase con mayor residuo para que la suma de frecuencias teóricas cierre exactamente en {n_total}."
        )

    interpretacion = (
        f"La distribución agrupada de {n_total} observaciones tiene media X̄ = {fmt(media, 2)} y desviación σ = {fmt(sigma, 2)}. "
        f"El pico máximo de la campana ajustada alcanza Y₀ = {fmt(y0, 2)} y las frecuencias teóricas esperadas cierran exactamente en {sum(f_teoricas)}."
    )

    return construir_resultado(
        titulo="Ajuste de Frecuencias de la Curva Normal",
        etiqueta="Altura máxima (Y₀)",
        valor=y0,
        formato="numero",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_ajuste_curva(
            etiquetas, pms, f_reales, f_teoricas, media, sigma, y0, ancho_i
        ),
        notas=notas,
    )


def _grafico_area_z(
    mu: float, sigma: float, tipo_area: str, x1: float, x2: float | None, z1: float, z2: float | None
) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    x_min = mu - 4 * sigma
    x_max = mu + 4 * sigma
    xs = [x_min + (x_max - x_min) * i / 300 for i in range(301)]
    ys = [
        (1.0 / (sigma * math.sqrt(2.0 * math.pi)))
        * math.exp(-0.5 * (((xv - mu) / sigma) ** 2))
        for xv in xs
    ]

    ax.plot(xs, ys, color=COLOR_CYAN, linewidth=2.2, label="Curva Normal")

    if tipo_area == "mayor":
        xs_f = [xv for xv in xs if xv >= x1]
        ys_f = [yv for xv, yv in zip(xs, ys) if xv >= x1]
        cortes = [x1]
    elif tipo_area == "menor":
        xs_f = [xv for xv in xs if xv <= x1]
        ys_f = [yv for xv, yv in zip(xs, ys) if xv <= x1]
        cortes = [x1]
    else:
        lo, hi = min(x1, x2), max(x1, x2)
        xs_f = [xv for xv in xs if lo <= xv <= hi]
        ys_f = [yv for xv, yv in zip(xs, ys) if lo <= xv <= hi]
        cortes = [lo, hi]

    if xs_f:
        ax.fill_between(xs_f, ys_f, color=COLOR_GREEN, alpha=0.32, label="Área calculada")

    for c in cortes:
        if x_min <= c <= x_max:
            ax.axvline(c, color=COLOR_YELLOW, linestyle="--", linewidth=1.6)

    ax.axvline(mu, color="#64748b", linestyle=":", linewidth=1.2, label=f"Media = {fmt(mu, 2)}")
    ax.set_xlabel("Escala de la variable")
    ax.set_ylabel("Densidad")
    sub = f"Z = {fmt(z1, 2)}" if z2 is None else f"Z₁ = {fmt(z1, 2)}, Z₂ = {fmt(z2, 2)}"
    ax.set_title(f"Área bajo la Curva Normal ({sub})", pad=14)
    ax.legend(loc="upper right")

    return guardar_figura(fig, "u3", "area_z")


def _area_bajo_curva(params: dict, es_z_directo: bool) -> dict:
    tipo_area = str(params.get("tipo_area") or "entre").strip().lower()

    if es_z_directo:
        mu, sigma = 0.0, 1.0
        x1 = float(a_numero(params.get("val_1"), "valor Z₁"))
        z1 = x1
        x2 = float(a_numero(params.get("val_2"), "valor Z₂")) if tipo_area == "entre" else None
        z2 = x2
        n_pob = None
    else:
        mu = float(a_numero(params.get("media_curva"), "media aritmética (X̄)"))
        sigma = float(a_numero(params.get("desv_curva"), "desviación típica (σ)", minimo=0.0001))
        x1 = float(a_numero(params.get("val_1"), "valor x₁"))
        z1 = (x1 - mu) / sigma
        if tipo_area == "entre":
            x2 = float(a_numero(params.get("val_2"), "valor x₂"))
            z2 = (x2 - mu) / sigma
        else:
            x2, z2 = None, None

        raw_n = str(params.get("poblacion_n") or "").strip()
        n_pob = int(a_numero(raw_n, "total de individuos (n)", entero=True, minimo=1)) if raw_n else None

    def phi(z: float) -> float:
        return 0.5 * (1.0 + math.erf(z / math.sqrt(2.0)))

    def area_central(z: float) -> float:
        return abs(phi(z) - 0.5)

    pasos = []
    if not es_z_directo:
        if z2 is None:
            pasos.append(
                f"1. Estandarización Z: Z = ({fmt(x1, 2)} − {fmt(mu, 2)}) / {fmt(sigma, 2)} = {fmt(z1, 2)}."
            )
        else:
            pasos.append(
                f"1. Estandarización Z: Z₁ = ({fmt(x1, 2)} − {fmt(mu, 2)}) / {fmt(sigma, 2)} = {fmt(z1, 2)} | "
                f"Z₂ = ({fmt(x2, 2)} − {fmt(mu, 2)}) / {fmt(sigma, 2)} = {fmt(z2, 2)}."
            )
    else:
        pasos.append(
            f"1. Valores Z directos: Z₁ = {fmt(z1, 2)}"
            + (f", Z₂ = {fmt(z2, 2)}." if z2 is not None else ".")
        )

    ac1 = area_central(z1)
    if tipo_area == "mayor":
        prob = 1.0 - phi(z1)
        regla = (
            f"Cola derecha (Z > {fmt(z1, 2)}): "
            f"{'0.5 − ' + fmt(ac1, 4) if z1 >= 0 else '0.5 + ' + fmt(ac1, 4)} = {fmt(prob, 4)}."
        )
        etiqueta_res = f"P(Z > {fmt(z1, 2)})"
    elif tipo_area == "menor":
        prob = phi(z1)
        regla = (
            f"Cola izquierda (Z < {fmt(z1, 2)}): "
            f"{'0.5 + ' + fmt(ac1, 4) if z1 >= 0 else '0.5 − ' + fmt(ac1, 4)} = {fmt(prob, 4)}."
        )
        etiqueta_res = f"P(Z < {fmt(z1, 2)})"
    else:
        if z1 > z2:
            x1, x2 = x2, x1
            z1, z2 = z2, z1
            ac1 = area_central(z1)
        ac2 = area_central(z2)
        prob = phi(z2) - phi(z1)
        if z1 < 0 and z2 > 0:
            regla = (
                f"Signos opuestos (− y +): se suman áreas centrales → "
                f"{fmt(ac1, 4)} + {fmt(ac2, 4)} = {fmt(prob, 4)}."
            )
        else:
            regla = (
                f"Mismo signo: se restan áreas centrales → "
                f"|{fmt(ac2, 4)} − {fmt(ac1, 4)}| = {fmt(prob, 4)}."
            )
        etiqueta_res = f"P({fmt(z1, 2)} < Z < {fmt(z2, 2)})"

    pasos.append(f"2. Área central en tabla Z₁ (0 → |{fmt(z1, 2)}|): {fmt(ac1, 4)}.")
    if z2 is not None:
        pasos.append(f"3. Área central en tabla Z₂ (0 → |{fmt(z2, 2)}|): {fmt(area_central(z2), 4)}.")
    pasos.append(f"{'4' if z2 is not None else '3'}. Cálculo de área: {regla}")

    metricas = [
        metrica("Área / Probabilidad", fmt(prob, 4)),
        metrica("Porcentaje (%)", fmt_pct(prob, 2)),
        metrica("Z₁ estandarizado", fmt(z1, 2)),
        metrica("Área central (0 → |Z₁|)", fmt(ac1, 4)),
    ]
    if z2 is not None:
        metricas.extend([
            metrica("Z₂ estandarizado", fmt(z2, 2)),
            metrica("Área central (0 → |Z₂|)", fmt(area_central(z2), 4)),
        ])

    if n_pob is not None:
        esperados = (n_pob * (prob * 100.0)) / 100.0
        esperados_red = int(round(esperados))
        metricas.append(metrica(f"Individuos esperados (n={n_pob})", f"{esperados_red} ({fmt(esperados, 2)})"))
        pasos.append(
            f"Cantidad esperada: a = ({n_pob} · {fmt(prob * 100.0, 2)}) / 100 = {fmt(esperados, 2)} ≈ {esperados_red} individuos."
        )

    tabla = {
        "columnas": ["Parámetro", "Valor"],
        "filas": [
            ["Condición evaluada", etiqueta_res],
            ["Área bajo la curva (decimal)", fmt(prob, 4)],
            ["Porcentaje equivalente", fmt_pct(prob, 2)],
        ]
        + (
            [[f"Cantidad esperada en n = {n_pob}", f"{int(round(n_pob * prob))} ({fmt(n_pob * prob, 2)})"]]
            if n_pob
            else []
        ),
    }

    interpretacion = (
        f"El área bajo la curva normal para {etiqueta_res} es {fmt(prob, 4)}, "
        f"lo que representa el {fmt_pct(prob, 2)} del total de observaciones."
        + (
            f" En una población de n = {n_pob}, esto corresponde aproximadamente a {int(round(n_pob * prob))} individuos."
            if n_pob
            else ""
        )
    )

    return construir_resultado(
        titulo="Área bajo la Curva Normal (Puntuación Z)",
        etiqueta=etiqueta_res,
        valor=prob,
        formato="probabilidad",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_area_z(mu, sigma, tipo_area, x1, x2, z1, z2),
    )

    # ---------------------------------------------------------------------------
# 6. Muestreo y Tamaño de Muestra (Apuntes U3)
# ---------------------------------------------------------------------------
def _grafico_estratificado(nombres: list[str], muestras_ni: list[int], n_total: int) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    posiciones = list(range(len(nombres)))
    barras = ax.bar(
        posiciones,
        muestras_ni,
        width=0.58,
        color=COLOR_CYAN,
        alpha=0.88,
        edgecolor=COLOR_BG,
        linewidth=1.2,
    )

    for barra, ni in zip(barras, muestras_ni):
        pct = (ni / n_total) * 100 if n_total > 0 else 0
        ax.text(
            barra.get_x() + barra.get_width() / 2,
            ni + (max(muestras_ni) * 0.025),
            f"{ni} ({pct:.1f}%)",
            ha="center",
            va="bottom",
            fontsize=8.5,
            color=COLOR_TEXT,
        )

    ax.set_xticks(posiciones)
    ax.set_xticklabels(nombres, rotation=18 if len(nombres) > 4 else 0)
    ax.set_xlabel("Estratos de la población")
    ax.set_ylabel("Unidades asignadas (nᵢ)")
    ax.set_title(f"Asignación Proporcional por Estratos (n = {n_total})", pad=14)
    ax.set_ylim(0, max(muestras_ni) * 1.2 if muestras_ni else 1)

    return guardar_figura(fig, "u3", "estratificado")


def _grafico_tamano_muestra(z_val: float, error_e: float, n_calc: float, n_redondeado: int, variabilidad: float, n_pob: int | None) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(10.5, 4.6))

    # Curva de sensibilidad de n respecto al margen de error E
    factores = [0.5, 0.75, 1.0, 1.25, 1.5, 2.0]
    errores = [error_e * f for f in factores]
    tamanos = []
    for err in errores:
        num = (z_val ** 2) * variabilidad
        if n_pob is None:
            tamanos.append(num / (err ** 2))
        else:
            tamanos.append((n_pob * num) / ((err ** 2) * (n_pob - 1) + num))

    ax.plot(errores, tamanos, color=COLOR_CYAN, linewidth=2.2, marker="o", label="Curva tamaño de muestra n(E)")
    ax.scatter([error_e], [n_calc], color=COLOR_YELLOW, zorder=5, s=75, label=f"Punto elegido (E={fmt(error_e, 4)} → n={n_redondeado})")
    ax.axvline(error_e, color=COLOR_YELLOW, linestyle="--", linewidth=1.3)

    ax.set_xlabel("Error máximo permisible (E)")
    ax.set_ylabel("Tamaño de muestra requerido (n)")
    ax.set_title("Sensibilidad del Tamaño de Muestra según el Error (E)", pad=14)
    ax.legend(loc="upper right")

    return guardar_figura(fig, "u3", "muestra")


def _tamano_muestra(params: dict) -> dict:
    modo = str(params.get("modo_muestreo") or "proporcion").strip().lower()

    # MODO 3: MUESTREO ALEATORIO ESTRATIFICADO PROPORCIONAL
    if modo == "estratificado":
        raw_nombres = str(params.get("estratos_nombres") or "").strip()
        nombres = [x.strip() for x in raw_nombres.split(",") if x.strip()]
        tamanos_ni = parsear_enteros(params.get("estratos_tamanos"), "población por estrato (Nᵢ)")
        n_muestra = int(a_numero(params.get("muestra_total_n"), "tamaño total de muestra (n)", entero=True, minimo=1))

        if not nombres:
            fallo("Debes ingresar los nombres de los estratos separados por comas.")
        if len(nombres) != len(tamanos_ni):
            fallo("La cantidad de nombres de estratos debe coincidir con la cantidad de tamaños Nᵢ.")
        if any(ni <= 0 for ni in tamanos_ni):
            fallo("Todos los estratos deben tener una población Nᵢ mayor que cero.")

        n_poblacion = sum(tamanos_ni)
        if n_muestra > n_poblacion:
            fallo(f"El tamaño de muestra ({n_muestra}) no puede superar la población total ({n_poblacion}).")

        proporciones = [ni / n_poblacion for ni in tamanos_ni]
        cuotas_exactas = [n_muestra * prop for prop in proporciones]
        cuotas_red = [int(round(c)) for c in cuotas_exactas]

        # Ajuste convencional de residuos para garantizar suma exacta en n_muestra
        dif = n_muestra - sum(cuotas_red)
        if dif != 0:
            residuos = [(ce - round(ce), idx) for idx, ce in enumerate(cuotas_exactas)]
            if dif > 0:
                residuos.sort(reverse=True)
                for k in range(abs(dif)):
                    _, idx_obj = residuos[k % len(residuos)]
                    cuotas_red[idx_obj] += 1
            else:
                residuos.sort()
                for k in range(abs(dif)):
                    _, idx_obj = residuos[k % len(residuos)]
                    if cuotas_red[idx_obj] > 1:
                        cuotas_red[idx_obj] -= 1

        filas = []
        for nom, ni_pob, prop, c_ex, c_rd in zip(nombres, tamanos_ni, proporciones, cuotas_exactas, cuotas_red):
            filas.append([
                nom,
                str(ni_pob),
                f"{fmt(prop, 4)} ({fmt_pct(prop, 2)})",
                fmt(c_ex, 2),
                str(c_rd),
            ])
        filas.append(["Σ Total", str(n_poblacion), "1.0000 (100%)", fmt(sum(cuotas_exactas), 2), str(sum(cuotas_red))])

        tabla = {
            "columnas": ["Estrato", "Población (Nᵢ)", "Proporción (Nᵢ/N)", "Muestra exacta", "Muestra asignada (nᵢ)"],
            "filas": filas,
        }

        metricas = [
            metrica("Población total (N)", str(n_poblacion)),
            metrica("Muestra total (n)", str(n_muestra)),
            metrica("Fracción muestral (n/N)", fmt_pct(n_muestra / n_poblacion, 2)),
            metrica("Intervalo sistemático (K)", fmt(n_poblacion / n_muestra, 2)),
            metrica("Total de estratos", str(len(nombres))),
        ]

        pasos = [
            f"1. Población total N = {' + '.join(str(x) for x in tamanos_ni)} = {n_poblacion}.",
            f"2. Proporción por estrato: hᵢ = Nᵢ / {n_poblacion}.",
            f"3. Asignación proporcional: nᵢ = {n_muestra} · (Nᵢ / {n_poblacion}) y redondeo ajustado para sumar {n_muestra}.",
        ]

        interpretacion = (
            f"Para una población estratificada de N = {n_poblacion} unidades dividida en {len(nombres)} estratos, "
            f"una muestra representativa de n = {n_muestra} ({fmt_pct(n_muestra / n_poblacion, 2)}) se reparte proporcionalmente "
            f"garantizando que la suma de submuestras cierre exactamente en {sum(cuotas_red)}."
        )

        return construir_resultado(
            titulo="Muestreo Aleatorio Estratificado Proporcional",
            etiqueta="Muestra repartida (n)",
            valor=sum(cuotas_red),
            formato="numero",
            metricas=metricas,
            pasos=pasos,
            interpretacion=interpretacion,
            tabla=tabla,
            grafico_url=_grafico_estratificado(nombres, cuotas_red, sum(cuotas_red)),
        )

    # MODOS 1 Y 2: TAMAÑO DE MUESTRA (PROPORCIONES O VARIANZA)
    tipo_pob = str(params.get("tipo_poblacion") or "infinita").strip().lower()
    confianza = float(a_numero(params.get("confianza"), "nivel de confianza"))
    error_e = float(a_numero(params.get("error_m"), "error muestral (E)", minimo=0.000001))

    tabla_z = {0.90: 1.645, 0.95: 1.96, 0.99: 2.576}
    z_val = tabla_z.get(round(confianza, 2), 1.96)

    n_pob = None
    if tipo_pob == "finita":
        n_pob = int(a_numero(params.get("poblacion_N"), "tamaño de población (N)", entero=True, minimo=2))

    if modo == "varianza":
        sigma = float(a_numero(params.get("sigma_muestra"), "desviación estándar (σ)", minimo=0.0001))
        variabilidad = sigma ** 2
        desc_var = f"σ² = ({fmt(sigma, 4)})² = {fmt(variabilidad, 4)}"
    else:
        p = a_probabilidad(params.get("p"), "probabilidad de éxito (p)")
        raw_q = str(params.get("q") or "").strip()
        q = a_probabilidad(raw_q, "probabilidad de fracaso (q)") if raw_q else (1.0 - p)
        if abs((p + q) - 1.0) > 0.01:
            fallo(f"La suma p + q debe ser igual a 1 (actualmente p + q = {fmt(p + q, 4)}).")
        variabilidad = p * q
        desc_var = f"p · q = {fmt(p, 4)} · {fmt(q, 4)} = {fmt(variabilidad, 4)}"

    numerador_inf = (z_val ** 2) * variabilidad
    if n_pob is None:
        n_exacto = numerador_inf / (error_e ** 2)
        formula_usada = "n = (Z² · σ²) / E²" if modo == "varianza" else "n = (Z² · p · q) / E²"
    else:
        numerador_fin = n_pob * numerador_inf
        denominador_fin = ((error_e ** 2) * (n_pob - 1)) + numerador_inf
        n_exacto = numerador_fin / denominador_fin
        formula_usada = "n = (N · Z² · σ²) / [E²(N − 1) + Z² · σ²]" if modo == "varianza" else "n = (N · Z² · p · q) / [E²(N − 1) + Z² · p · q]"

    n_redondeado = int(math.ceil(n_exacto))

    metricas = [
        metrica("Muestra recomendada (n)", str(n_redondeado), f"Exacto: {fmt(n_exacto, 2)}"),
        metrica("Valor crítico Z", fmt(z_val, 3), f"Confianza: {fmt_pct(confianza, 0)}"),
        metrica("Error máximo (E)", fmt(error_e, 4)),
        metrica("Variabilidad", fmt(variabilidad, 4)),
        metrica("Tipo de población", "Finita (N=" + str(n_pob) + ")" if n_pob else "Infinita"),
    ]
    if n_pob:
        metricas.append(metrica("Intervalo sistemático (K)", fmt(n_pob / n_redondeado, 2)))

    pasos = [
        f"1. Parámetros: Confianza = {fmt_pct(confianza, 0)} → Z = {fmt(z_val, 3)}, E = {fmt(error_e, 4)}, {desc_var}.",
        f"2. Fórmula aplicada ({'Población Finita' if n_pob else 'Población Infinita'}): {formula_usada}.",
        f"3. Sustitución: n = {fmt(n_exacto, 4)}.",
        f"4. Redondeo estadístico al entero superior: n = {n_redondeado} unidades.",
    ]

    tabla = {
        "columnas": ["Concepto", "Valor"],
        "filas": [
            ["Nivel de confianza", f"{fmt_pct(confianza, 0)} (Z = {fmt(z_val, 3)})"],
            ["Error muestral (E)", fmt(error_e, 4)],
            ["Variabilidad aplicada", desc_var],
            ["Tamaño exacto calculado", fmt(n_exacto, 4)],
            ["Tamaño de muestra final (n)", str(n_redondeado)],
        ],
    }

    interpretacion = (
        f"Para trabajar con un nivel de confianza del {fmt_pct(confianza, 0)} (Z = {fmt(z_val, 3)}) y un error máximo permisible E = {fmt(error_e, 4)}, "
        f"se requiere encuestar o evaluar una muestra de n = {n_redondeado} unidades elementales."
    )

    return construir_resultado(
        titulo="Cálculo del Tamaño de la Muestra",
        etiqueta="Tamaño de muestra (n)",
        valor=n_redondeado,
        formato="numero",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=_grafico_tamano_muestra(z_val, error_e, n_exacto, n_redondeado, variabilidad, n_pob),
    )


def _ajuste_normal(params: dict) -> dict:
    modo = str(params.get("modo_curva") or "ajuste").strip().lower()
    if modo == "area_datos":
        return _area_bajo_curva(params, es_z_directo=False)
    elif modo == "area_z":
        return _area_bajo_curva(params, es_z_directo=True)
    else:
        return _ajuste_frecuencias(params)


def main() -> None:
    payload = leer_payload()
    accion = payload.get("action") or payload.get("accion")
    params = obtener_params(payload)

    if accion == "u3_variable_aleatoria":
        resultado = _variable_aleatoria(params)
        responder({"ok": True, "resultado": resultado})
    elif accion == "u3_binomial":
        resultado = _binomial(params)
        responder({"ok": True, "resultado": resultado})
    elif accion == "u3_poisson":
        resultado = _poisson(params)
        responder({"ok": True, "resultado": resultado})
    elif accion == "u3_normal":
        resultado = _normal(params)
        responder({"ok": True, "resultado": resultado})
    elif accion == "u3_ajuste_normal":
        resultado = _ajuste_normal(params)
        responder({"ok": True, "resultado": resultado})
    elif accion == "u3_tamano_muestra":
        resultado = _tamano_muestra(params)
        responder({"ok": True, "resultado": resultado})

    else:
        fallo(f"Acción no reconocida en procesador_u3: {accion}")


if __name__ == "__main__":
    main()
