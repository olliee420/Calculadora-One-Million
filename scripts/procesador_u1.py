# scripts/procesador_u1.py
import math
import matplotlib
matplotlib.use("Agg")
import matplotlib.pyplot as plt

from comun import (
    COLOR_BG,
    COLOR_BLUE,
    COLOR_CYAN,
    COLOR_GREEN,
    COLOR_MUTED,
    COLOR_TEXT,
    COLOR_YELLOW,
    a_numero,
    a_texto,
    configurar_estilo,
    construir_resultado,
    fallo,
    fmt,
    fmt_pct,
    guardar_figura,
    leer_payload,
    metrica,
    obtener_params,
    parsear_lista,
    responder,
)


# ---------------------------------------------------------------------------
# 1. Tablas de Distribución de Frecuencia
# ---------------------------------------------------------------------------
def _grafico_histograma(etiquetas: list[str], frecuencias: list[int], puntos_medios: list[float]) -> str:
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(9.2, 4.6))

    x_pos = list(range(len(etiquetas)))
    barras = ax.bar(
        x_pos,
        frecuencias,
        width=0.92,
        color=COLOR_GREEN,
        edgecolor=COLOR_BG,
        linewidth=1.5,
        alpha=0.88,
        label="Frecuencia absoluta (f)",
    )

    # Polígono de frecuencias superpuesto
    ax.plot(
        x_pos,
        frecuencias,
        color=COLOR_CYAN,
        marker="o",
        linewidth=2.2,
        markersize=6,
        label="Polígono de frecuencias",
    )

    for barra, freq in zip(barras, frecuencias):
        ax.text(
            barra.get_x() + barra.get_width() / 2,
            barra.get_height() + max(frecuencias) * 0.025,
            str(freq),
            ha="center",
            va="bottom",
            fontsize=10,
            color=COLOR_TEXT,
            fontweight="bold",
        )

    ax.set_xticks(x_pos)
    ax.set_xticklabels(etiquetas, rotation=15, ha="right")
    ax.set_ylim(0, max(frecuencias) * 1.18 + 1)
    ax.set_xlabel("Intervalos de clase [Li - Ls)")
    ax.set_ylabel("Frecuencia absoluta (f)")
    ax.set_title("Histograma y Polígono de Frecuencias", pad=14)
    ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)
    ax.legend(loc="upper right")

    return guardar_figura(fig, "u1", "tabla_frecuencia")


def _tabla_frecuencia(params: dict) -> dict:
    datos = parsear_lista(params.get("datos"), "datos brutos")
    n = len(datos)
    if n < 2:
        fallo("Ingresa al menos 2 datos numéricos para construir la tabla de frecuencias.")

    modo = a_texto(params.get("modo"), "auto").lower()
    ordenados = sorted(datos)
    d_menor = ordenados[0]
    d_mayor = ordenados[-1]
    rango = d_mayor - d_menor

    if rango <= 0:
        fallo("Todos los datos son iguales (Rango = 0); no se pueden formar intervalos.")

    # Paso 2: Número de clases (Sturges según apuntes: Nc = 1 + 3.33 * log10(N))
    sturges_exacto = 1.0 + 3.33 * math.log10(n)
    if modo == "manual":
        nc = int(a_numero(params.get("clases"), "número de clases (Nc)", entero=True, minimo=2, maximo=30))
    else:
        nc = max(2, round(sturges_exacto))

    # Paso 3: Intervalo de clase (Ic = R / Nc), asegurando Nc * Ic >= R
    ic_exacto = rango / nc
    if all(float(x).is_integer() for x in datos):
        ic = math.ceil(ic_exacto)
        if nc * ic < rango:
            ic += 1
    else:
        ic = round(ic_exacto, 4)
        if nc * ic < rango:
            ic = round(ic_exacto + 0.01, 4)

       # Paso 4: Construcción de límites y conteo [Li, Ls)
    filas = []
    etiquetas_graf = []
    frecuencias_graf = []
    puntos_medios_graf = []

    lim_inf = d_menor
    f_acum = 0

    for i in range(nc):
        lim_sup = lim_inf + ic
        if all(float(x).is_integer() for x in datos) and float(ic).is_integer():
            lim_inf_fmt = int(round(lim_inf))
            lim_sup_fmt = int(round(lim_sup))
            clase_str = f"{lim_inf_fmt} - {lim_sup_fmt}"
        else:
            clase_str = f"{fmt(lim_inf, 2)} - {fmt(lim_sup, 2)}"

        # Regla de tus apuntes: el límite superior no se incluye, pasa a la siguiente (excepto en la última clase)
        if i < nc - 1:
            freq = sum(1 for x in ordenados if lim_inf <= x < lim_sup)
        else:
            freq = sum(1 for x in ordenados if lim_inf <= x <= lim_sup + 1e-9)

        fr = freq / n
        f_acum += freq
        pm = (lim_inf + lim_sup) / 2.0

        filas.append([
            clase_str,
            fmt(pm, 2),
            str(freq),
            str(f_acum),
            fmt(fr, 4),
            fmt_pct(fr, 2),
        ])

        etiquetas_graf.append(clase_str)
        frecuencias_graf.append(freq)
        puntos_medios_graf.append(pm)

        lim_inf = lim_sup

    filas.append([
        f"Total (Nc × Ic = {fmt(nc * ic, 2)} ≥ {fmt(rango, 2)})",
        fmt(sum(puntos_medios_graf), 2),
        str(n),
        "—",
        "1.0000",
        "100%",
    ])


    tabla = {
        "columnas": [
            "Intervalos de clase",
            "Marca de clase (Pm)",
            "Frecuencia absoluta (F)",
            "Frecuencia acumulada (Fi)",
            "Frecuencia relativa (Fr)",
            "Frecuencia porcentual (%)",
        ],
        "filas": filas,
    }
        # Construcción de la Tabla Completa (con Ojivas menos/más que, pares ordenados y Pm·f)
    filas_completas = []
    fa_menos = 0
    fa_mas = n
    suma_pm_f = 0.0

    lim_inf = d_menor
    for i in range(nc):
        lim_sup = lim_inf + ic
        if all(float(x).is_integer() for x in datos) and float(ic).is_integer():
            li_txt = str(int(round(lim_inf)))
            ls_txt = str(int(round(lim_sup)))
            clase_str = f"{li_txt} - {ls_txt}"
        else:
            li_txt = fmt(lim_inf, 2)
            ls_txt = fmt(lim_sup, 2)
            clase_str = f"{li_txt} - {ls_txt}"

        freq = frecuencias_graf[i]
        pm = puntos_medios_graf[i]
        fr = freq / n
        porc = fr * 100.0
        fa_menos += freq
        pm_por_f = pm * freq
        suma_pm_f += pm_por_f

        # Pares ordenados según tus apuntes:
        # Ojiva "menos que": (Límite Superior, Fa menos que)
        # Ojiva "más que": (Límite Inferior, Fa más que)
        par_menos = f"({ls_txt}, {fa_menos})"
        par_mas = f"({li_txt}, {fa_mas})"

        filas_completas.append([
            f"C{i + 1}",
            clase_str,
            fmt(pm, 2),
            str(freq),
            fmt(fr, 4),
            f"{fmt(porc, 2)}%",
            str(fa_menos),
            str(fa_mas),
            par_menos,
            par_mas,
            fmt(pm_por_f, 2),
        ])

        fa_mas -= freq
        lim_inf = lim_sup

    filas_completas.append([
        "Total",
        f"Nc={nc}, Ic={fmt(ic)}",
        "—",
        str(n),
        "1.0000",
        "100%",
        "—",
        "—",
        f"({li_txt}, 0)",
        f"({ls_txt}, 0)",
        fmt(suma_pm_f, 2),
    ])

    tabla_completa = {
        "columnas": [
            "#",
            "Intervalos",
            "Pm (Xi)",
            "f (fi)",
            "fr (hi)",
            "%",
            "Fa 'menos que' (↑)",
            "Fa 'más que' (↓)",
            "Par (x, y) menos que",
            "Par (x, y) más que",
            "Pm · f",
        ],
        "filas": filas_completas,
    }

    
    metricas = [
        metrica("Total datos (N)", str(n)),
        metrica("Dato menor / mayor", f"{fmt(d_menor)} / {fmt(d_mayor)}"),
        metrica("Rango (R)", fmt(rango)),
        metrica("Clases (Nc)", str(nc)),
        metrica("Intervalo (Ic)", fmt(ic)),
        metrica("Comprobación Nc × Ic", f"{fmt(nc * ic)} ≥ {fmt(rango)}"),
    ]

    arreglo_preview = ", ".join(fmt(x) for x in ordenados[:25])
    if n > 25:
        arreglo_preview += f", ... (+{n - 25} datos más)"

    pasos = [
        f"Arreglo ordenado ({n} datos): [{arreglo_preview}]",
        f"Paso 1 (Rango): R = D_mayor - D_menor = {fmt(d_mayor)} - {fmt(d_menor)} = {fmt(rango)}",
        f"Paso 2 (Número de clases - Sturges): Nc = 1 + 3.33 · log10({n}) = {fmt(sturges_exacto, 2)} → Nc = {nc}",
        f"Paso 3 (Intervalo de clase): Ic = R / Nc = {fmt(rango)} / {nc} = {fmt(ic_exacto, 2)} → Ic = {fmt(ic)}",
        f"Buena práctica: Nc × Ic = {nc} × {fmt(ic)} = {fmt(nc * ic)} ≥ R ({fmt(rango)})",
        "Paso 4 (Límites y conteo): Se cuentan los datos en [Li, Ls), pasando el límite superior a la clase siguiente.",
    ]

    clase_modal_idx = frecuencias_graf.index(max(frecuencias_graf))
    interpretacion = (
        f"Los {n} datos se organizaron en {nc} clases de amplitud {fmt(ic)}. "
        f"La mayor concentración de observaciones se encuentra en el intervalo "
        f"{etiquetas_graf[clase_modal_idx]} con {frecuencias_graf[clase_modal_idx]} datos "
        f"({fmt_pct(frecuencias_graf[clase_modal_idx] / n, 1)} del total)."
    )

    etiquetas_str = ", ".join(etiquetas_graf)
    frecuencias_str = ", ".join(str(f) for f in frecuencias_graf)

    res_barras = _graficos({
        "tipo_grafico": "barras",
        "titulo_graf": "Frecuencias absolutas por intervalo de clase",
        "etiquetas": etiquetas_str,
        "frecuencias": frecuencias_str,
    })
    res_circular = _graficos({
        "tipo_grafico": "circular",
        "titulo_graf": "Distribución porcentual por intervalo",
        "etiquetas": etiquetas_str,
        "frecuencias": frecuencias_str,
    })
    res_histograma = _graficos({
        "tipo_grafico": "histograma",
        "titulo_graf": "Distribución continua y tendencia de frecuencias",
        "etiquetas": etiquetas_str,
        "frecuencias": frecuencias_str,
    })


    resultado = construir_resultado(
        titulo="Tabla de Distribución de Frecuencias",
        etiqueta="Clases (Nc)",
        valor=str(nc),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=res_barras.get("grafico_url"),
    )
    resultado["graficos"] = [
        {"titulo": "1. Gráfico de Barras", "url": res_barras.get("grafico_url")},
        {"titulo": "2. Gráfico Circular", "url": res_circular.get("grafico_url")},
        {"titulo": "3. Histograma y Polígono de Frecuencias", "url": res_histograma.get("grafico_url")},
    ]
    resultado["tabla_completa"] = tabla_completa
    return resultado



# ---------------------------------------------------------------------------
# 2. Representaciones Gráficas (Línea, Histograma, Ojivas, Barras, Circular)
# ---------------------------------------------------------------------------
def _graficos(params: dict) -> dict:
    tipo = a_texto(params.get("tipo_grafico"), "histograma").lower()
    titulo = a_texto(params.get("titulo_graf"), "Representación Gráfica")
    raw_etiquetas = a_texto(params.get("etiquetas"), "")
    etiquetas = [e.strip() for e in raw_etiquetas.split(",") if e.strip()]
    frecuencias = parsear_lista(params.get("frecuencias"), "frecuencias o valores")

    if len(frecuencias) < 2:
        fallo("Ingresa al menos 2 valores numéricos para generar el gráfico.")
    if any(f < 0 for f in frecuencias):
        fallo("Las frecuencias o valores no pueden ser negativos.")
    if len(etiquetas) != len(frecuencias):
        etiquetas = [f"Clase {i + 1}" for i in range(len(frecuencias))]

    total = sum(frecuencias)
    if total <= 0:
        fallo("La suma de las frecuencias debe ser mayor que 0.")

    configurar_estilo()
    fig, ax = plt.subplots(figsize=(9.2, 4.8))
    paleta = [COLOR_GREEN, COLOR_CYAN, COLOR_YELLOW, COLOR_BLUE, "#a855f7", "#f43f5e"]

    filas = []
    pasos = []
    metricas = [
        metrica("Total observaciones (n)", fmt(total)),
        metrica("Número de clases", str(len(frecuencias))),
    ]

    # 1. GRÁFICO DE LÍNEA
    if tipo == "linea":
        x_pos = list(range(len(etiquetas)))
        ax.plot(x_pos, frecuencias, color=COLOR_GREEN, marker="o", linewidth=2.5, markersize=7)
        for x, y in zip(x_pos, frecuencias):
            ax.text(x, y + max(frecuencias) * 0.03, fmt(y), ha="center", va="bottom", color=COLOR_TEXT, fontweight="bold")
        ax.set_xticks(x_pos)
        ax.set_xticklabels(etiquetas, rotation=15, ha="right")
        ax.set_ylim(0, max(frecuencias) * 1.18)
        ax.set_ylabel("Frecuencia / Valor (Y)")
        ax.set_xlabel("Clases / Periodos (X)")
        ax.grid(True, color="#1e293b", linestyle="--", alpha=0.6)

        for et, fr in zip(etiquetas, frecuencias):
            filas.append([et, fmt(fr), fmt_pct(fr / total, 2)])
        tabla = {"columnas": ["Clase / Periodo (X)", "Valor (Y)", "Proporción (%)"], "filas": filas}
        pasos = [
            "Se ubican las clases o periodos en el eje horizontal (X) y las frecuencias en el eje vertical (Y).",
            "Se trazan los puntos (X, Y) y se unen consecutivamente mediante segmentos de recta.",
        ]
        interpretacion = f"El gráfico de línea muestra la evolución de los {len(frecuencias)} puntos, alcanzando un máximo de {fmt(max(frecuencias))} y un mínimo de {fmt(min(frecuencias))}."

    # 2. HISTOGRAMA Y POLÍGONO DE FRECUENCIAS
    elif tipo == "histograma":
        x_pos = list(range(len(etiquetas)))
        barras = ax.bar(x_pos, frecuencias, width=1.0, color=COLOR_GREEN, edgecolor=COLOR_BG, linewidth=1.8, alpha=0.85, label="Histograma (Pearson)")
        ax.plot(x_pos, frecuencias, color=COLOR_CYAN, marker="o", linewidth=2.4, markersize=6, label="Polígono de frecuencias")
        for barra, fr in zip(barras, frecuencias):
            ax.text(barra.get_x() + barra.get_width() / 2, barra.get_height() + max(frecuencias) * 0.025, fmt(fr), ha="center", va="bottom", color=COLOR_TEXT, fontweight="bold")
        ax.set_xticks(x_pos)
        ax.set_xticklabels(etiquetas)
        ax.set_ylim(0, max(frecuencias) * 1.18)
        ax.set_xlabel("Intervalos de clase")
        ax.set_ylabel("Frecuencia absoluta (f)")
        ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)
        ax.legend(loc="upper right")

        for et, fr in zip(etiquetas, frecuencias):
            filas.append([et, fmt(fr), fmt_pct(fr / total, 2)])
        tabla = {"columnas": ["Intervalo", "Frecuencia (f)", "Frec. Relativa (%)"], "filas": filas}
        pasos = [
            "Histograma (Gráfico de Pearson): rectángulos unidos cuya base corresponde al intervalo y su altura a la frecuencia.",
            "Polígono de frecuencias: segmentos de recta que unen los puntos medios superiores de cada rectángulo.",
        ]
        interpretacion = f"Distribución de {fmt(total)} datos en {len(frecuencias)} intervalos continuos sin separación entre barras."

    # 3. OJIVAS ("MENOS QUE" Y "MÁS QUE")
    elif tipo == "ojivas":
        raw_limites = a_texto(params.get("limites"), "")
        limites = [l.strip() for l in raw_limites.split(",") if l.strip()]
        if len(limites) != len(frecuencias) + 1:
            limites = [str(i) for i in range(len(frecuencias) + 1)]

        fa_menos = [0.0]
        acum = 0.0
        for fr in frecuencias:
            acum += fr
            fa_menos.append(acum)

        fa_mas = []
        restante = total
        for fr in frecuencias:
            fa_mas.append(restante)
            restante -= fr
        fa_mas.append(0.0)

        x_pos = list(range(len(limites)))
        ax.plot(x_pos, fa_menos, color=COLOR_GREEN, marker="o", linewidth=2.4, label='Ojiva "menos que" (Fa ↑)')
        ax.plot(x_pos, fa_mas, color=COLOR_YELLOW, marker="s", linewidth=2.4, label='Ojiva "más que" (Fa ↓)')
        ax.set_xticks(x_pos)
        ax.set_xticklabels(limites)
        ax.set_ylim(-total * 0.04, total * 1.12)
        ax.set_xlabel("Límites de clase")
        ax.set_ylabel("Frecuencia acumulada")
        ax.grid(True, color="#1e293b", linestyle="--", alpha=0.6)
        ax.legend(loc="center right")

        for i, fr in enumerate(frecuencias):
            filas.append([
                f"{limites[i]} - {limites[i + 1]}",
                fmt(fr),
                fmt(fa_menos[i + 1]),
                fmt(fa_mas[i]),
            ])
        tabla = {"columnas": ["Clase", "Frecuencia (f)", 'Fa "menos que" (↑)', 'Fa "más que" (↓)'], "filas": filas}
        pasos = [
            f'Ojiva "menos que": inicia en ({limites[0]}, 0) y sube hasta ({limites[-1]}, {fmt(total)}).',
            f'Ojiva "más que": inicia en ({limites[0]}, {fmt(total)}) y desciende hasta ({limites[-1]}, 0).',
        ]
        interpretacion = f"Ambas ojivas se cruzan exactamente en el 50% de los datos acumulados (mediana = {fmt(total / 2)} observaciones)."

    # 4. GRÁFICO DE BARRAS SEPARADAS
    elif tipo == "barras":
        x_pos = list(range(len(etiquetas)))
        colores = [paleta[i % len(paleta)] for i in range(len(etiquetas))]
        barras = ax.bar(x_pos, frecuencias, width=0.55, color=colores, edgecolor=COLOR_BG, linewidth=1.5)
        for barra, fr in zip(barras, frecuencias):
            ax.text(barra.get_x() + barra.get_width() / 2, barra.get_height() + max(frecuencias) * 0.025, fmt(fr), ha="center", va="bottom", color=COLOR_TEXT, fontweight="bold")
        ax.set_xticks(x_pos)
        ax.set_xticklabels(etiquetas, rotation=12, ha="right")
        ax.set_ylim(0, max(frecuencias) * 1.18)
        ax.set_ylabel("Frecuencia / Cantidad")
        ax.set_xlabel("Categorías")
        ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)

        for et, fr in zip(etiquetas, frecuencias):
            filas.append([et, fmt(fr), fmt_pct(fr / total, 2)])
        tabla = {"columnas": ["Categoría", "Frecuencia (f)", "Porcentaje (%)"], "filas": filas}
        pasos = [
            "A diferencia del histograma, los rectángulos se dibujan separados para indicar categorías independientes.",
        ]
        interpretacion = f"Comparación categórica de {fmt(total)} elementos distribuidos en {len(etiquetas)} barras separadas."

        # 5. DIAGRAMA CIRCULAR (REGLA DE TRES EN GRADOS)
    elif tipo == "circular":
        colores = [paleta[i % len(paleta)] for i in range(len(etiquetas))]
        grados = [(fr * 360.0) / total for fr in frecuencias]

        # Destacar ligeramente el sector con mayor frecuencia
        max_f = max(frecuencias)
        explode = [0.05 if fr == max_f else 0.0 for fr in frecuencias]

        wedges, texts, autotexts = ax.pie(
            frecuencias,
            explode=explode,
            colors=colores,
            autopct=lambda pct: f"{pct:.1f}%" if pct >= 4.0 else "",
            pctdistance=0.72,
            startangle=90,
            counterclock=False,
            wedgeprops=dict(edgecolor=COLOR_BG, linewidth=2.2, antialiased=True),
        )

        for autotext in autotexts:
            autotext.set_color("#060913")
            autotext.set_fontweight("bold")
            autotext.set_fontsize(9.5)

        etiquetas_leyenda = [
            f"{et}  →  {fmt(fr)} datos ({fmt(g, 2)}° · {fmt_pct(fr / total, 1)})"
            for et, fr, g in zip(etiquetas, frecuencias, grados)
        ]
        leyenda = ax.legend(
            wedges,
            etiquetas_leyenda,
            title="Intervalos y Distribución",
            loc="center left",
            bbox_to_anchor=(1.02, 0.5),
            frameon=True,
            facecolor="#0a0e1a",
            edgecolor="#334155",
            fontsize=8.8,
        )
        leyenda.get_title().set_color(COLOR_CYAN)
        leyenda.get_title().set_fontweight("bold")
        for text in leyenda.get_texts():
            text.set_color(COLOR_TEXT)

        ax.axis("equal")

        for et, fr, g in zip(etiquetas, frecuencias, grados):
            filas.append([et, fmt(fr), f"{fmt(g, 2)}°", fmt_pct(fr / total, 2)])
            pasos.append(f"Para {et}: X = ({fmt(fr)} × 360°) / {fmt(total)} = {fmt(g, 2)}°")
        filas.append(["Total", fmt(total), "360.00°", "100%"])
        tabla = {"columnas": ["Clase / Categoría", "Frecuencia (f)", "Ángulo (Grados)", "Porcentaje (%)"], "filas": filas}
        interpretacion = f"El círculo completo (360°) representa el total de {fmt(total)} observaciones dividido en {len(etiquetas)} sectores."
    else:
        fallo("Tipo de gráfico no reconocido.")

    if tipo != "circular":
        ax.set_title(titulo, pad=14)

    return construir_resultado(
        titulo=titulo,
        etiqueta="Total (n)",
        valor=fmt(total),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=guardar_figura(fig, "u1", f"grafico_{tipo}"),
    )

# ---------------------------------------------------------------------------
# 3. Medidas de Tendencia Central (Series Simples y Series Agrupadas)
# ---------------------------------------------------------------------------
def _tendencia_central(params: dict) -> dict:
    tipo = a_texto(params.get("tipo_datos"), "no_agrupados").lower()

    # -----------------------------------------------------------------------
    # MODO 1: SERIES SIMPLES (DATOS NO AGRUPADOS)
    # -----------------------------------------------------------------------
    if tipo == "no_agrupados":
        datos = parsear_lista(params.get("datos"), "datos brutos")
        n = len(datos)
        if n < 2:
            fallo("Ingresa al menos 2 datos numéricos para calcular las medidas de tendencia central.")

        ordenados = sorted(datos)
        suma = sum(datos)
        media = suma / n

        # Mediana simple (impar vs par)
        if n % 2 == 1:
            idx = n // 2
            mediana = ordenados[idx]
            paso_mediana = f"Como n = {n} es impar, la mediana es el valor central (posición {idx + 1}): Md = {fmt(mediana)}"
        else:
            idx1 = (n // 2) - 1
            idx2 = n // 2
            mediana = (ordenados[idx1] + ordenados[idx2]) / 2.0
            paso_mediana = (
                f"Como n = {n} es par, se promedian los dos valores centrales "
                f"({fmt(ordenados[idx1])} y {fmt(ordenados[idx2])}): Md = ({fmt(ordenados[idx1])} + {fmt(ordenados[idx2])}) / 2 = {fmt(mediana)}"
            )

        # Moda simple
        conteos: dict[float, int] = {}
        for x in datos:
            conteos[x] = conteos.get(x, 0) + 1
        max_freq = max(conteos.values())
        if max_freq == 1:
            moda_txt = "Amodal (todos tienen frecuencia 1)"
            modas = []
        else:
            modas = [k for k, v in sorted(conteos.items()) if v == max_freq]
            moda_txt = ", ".join(fmt(m) for m in modas) + f" (f = {max_freq})"

        # Gráfico de línea / puntos con líneas de referencia
        configurar_estilo()
        fig, ax = plt.subplots(figsize=(9.0, 4.4))
        x_pos = list(range(1, n + 1))
        ax.plot(x_pos, ordenados, color=COLOR_CYAN, marker="o", linewidth=2, label="Datos ordenados")
        ax.axhline(media, color=COLOR_GREEN, linestyle="--", linewidth=2, label=f"Media (x̄) = {fmt(media, 2)}")
        ax.axhline(mediana, color=COLOR_YELLOW, linestyle="-.", linewidth=2, label=f"Mediana (Md) = {fmt(mediana, 2)}")
        for m in modas:
            ax.axhline(m, color="#a855f7", linestyle=":", linewidth=2, label=f"Moda (Mo) = {fmt(m, 2)}")
        ax.set_xlabel("Posición del dato ordenado")
        ax.set_ylabel("Valor")
        ax.set_title("Comparación de Medidas de Tendencia Central (Serie Simple)", pad=14)
        ax.grid(True, color="#1e293b", linestyle="--", alpha=0.6)
        ax.legend(loc="upper left")

        metricas = [
            metrica("Total datos (n)", str(n)),
            metrica("Sumatoria (ΣX)", fmt(suma)),
            metrica("Media Aritmética (x̄)", fmt(media, 4)),
            metrica("Mediana (Md)", fmt(mediana, 4)),
            metrica("Moda (Mo)", moda_txt),
        ]

        pasos = [
            f"Datos ordenados: [{', '.join(fmt(x) for x in ordenados)}]",
            f"Media Aritmética: x̄ = ΣX / n = {fmt(suma)} / {n} = {fmt(media, 4)}",
            paso_mediana,
            f"Moda: {moda_txt}",
        ]

        interpretacion = (
            f"En esta serie simple de {n} datos, el promedio es {fmt(media, 2)}, "
            f"el 50% central se divide en {fmt(mediana, 2)} y la moda es {moda_txt}."
        )

        return construir_resultado(
            titulo="Medidas de Tendencia Central (Serie Simple)",
            etiqueta="Media (x̄)",
            valor=fmt(media, 4),
            formato="texto",
            metricas=metricas,
            pasos=pasos,
            interpretacion=interpretacion,
            grafico_url=guardar_figura(fig, "u1", "tendencia_simple"),
        )

    # -----------------------------------------------------------------------
    # MODO 2: SERIES AGRUPADAS (CLASES Y FRECUENCIAS)
    # -----------------------------------------------------------------------
    raw_int = a_texto(params.get("intervalos"), "")
    partes_int = [p.strip() for p in raw_int.split(",") if p.strip()]
    frecuencias = parsear_lista(params.get("frecuencias"), "frecuencias absolutas (f)")

    if len(partes_int) < 2 or len(partes_int) != len(frecuencias):
        fallo("Ingresa al menos 2 intervalos (ej: 0-2, 2-4) y la misma cantidad de frecuencias.")

    lim_infs = []
    lim_sups = []
    for p in partes_int:
        if "-" not in p:
            fallo(f"El intervalo '{p}' debe tener formato 'Li - Ls' (ej: 20 - 34).")
        trozos = [t.strip() for t in p.split("-") if t.strip()]
        if len(trozos) != 2:
            fallo(f"Formato inválido en el intervalo '{p}'.")
        li, ls = float(trozos[0]), float(trozos[1])
        if ls <= li:
            fallo(f"En el intervalo '{p}', el límite superior debe ser mayor al inferior.")
        lim_infs.append(li)
        lim_sups.append(ls)

    if any(f < 0 for f in frecuencias):
        fallo("Las frecuencias no pueden ser negativas.")

    n = sum(frecuencias)
    if n <= 0:
        fallo("La suma de las frecuencias (n) debe ser mayor que 0.")

    # 1. Media agrupada: x̄ = Σ(Pm * f) / n
    pms = [(li + ls) / 2.0 for li, ls in zip(lim_infs, lim_sups)]
    pm_f = [pm * f for pm, f in zip(pms, frecuencias)]
    suma_pm_f = sum(pm_f)
    media = suma_pm_f / n

    # Frecuencias acumuladas
    fas = []
    acum = 0.0
    for f in frecuencias:
        acum += f
        fas.append(acum)

    # 2. Mediana agrupada: Md = Li + i * [ (n/2 - Faa) / f ]
    mitad = n / 2.0
    idx_md = 0
    for i, fa in enumerate(fas):
        if fa >= mitad:
            idx_md = i
            break

    li_md = lim_infs[idx_md]
    i_md = lim_sups[idx_md] - lim_infs[idx_md]
    faa_md = fas[idx_md - 1] if idx_md > 0 else 0.0
    f_md = frecuencias[idx_md]
    mediana = li_md + i_md * ((mitad - faa_md) / f_md) if f_md > 0 else pms[idx_md]

    # 3. Moda agrupada (3 métodos de tus apuntes)
    idx_mo = frecuencias.index(max(frecuencias))
    li_mo = lim_infs[idx_mo]
    i_mo = lim_sups[idx_mo] - lim_infs[idx_mo]
    f_mo = frecuencias[idx_mo]
    f_ant = frecuencias[idx_mo - 1] if idx_mo > 0 else 0.0
    f_post = frecuencias[idx_mo + 1] if idx_mo < len(frecuencias) - 1 else 0.0

    moda_pm = pms[idx_mo]
    delta1 = f_mo - f_ant
    delta2 = f_mo - f_post
    moda_interp = li_mo + i_mo * (delta1 / (delta1 + delta2)) if (delta1 + delta2) > 0 else moda_pm
    moda_empirica = 3.0 * mediana - 2.0 * media

    filas = []
    for p, f, pm, pf, fa in zip(partes_int, frecuencias, pms, pm_f, fas):
        filas.append([p, fmt(f), fmt(pm, 2), fmt(pf, 2), fmt(fa)])
    filas.append(["Total", fmt(n), "—", fmt(suma_pm_f, 2), "—"])

    tabla = {
        "columnas": ["Clases", "Frecuencia (f)", "Punto Medio (Pm)", "Pm · f", "Frec. Acumulada (Fa)"],
        "filas": filas,
    }

    # Gráfico histograma + líneas verticales de Media, Mediana y Moda
    configurar_estilo()
    fig, ax = plt.subplots(figsize=(9.2, 4.6))
    x_pos = list(range(len(partes_int)))
    ax.bar(x_pos, frecuencias, width=0.92, color="#334155", edgecolor=COLOR_BG, label="Frecuencia (f)")
    ax.set_xticks(x_pos)
    ax.set_xticklabels(partes_int, rotation=15, ha="right")
    ax.set_ylabel("Frecuencia (f)")
    ax.set_title("Distribución Agrupada y Medidas Centrales", pad=14)
    ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)

    metricas = [
        metrica("Total datos (n)", fmt(n)),
        metrica("Media (x̄)", fmt(media, 4)),
        metrica("Mediana (Md)", fmt(mediana, 4)),
        metrica("Moda (Interpolación)", fmt(moda_interp, 4)),
        metrica("Moda (Punto Medio)", fmt(moda_pm, 4)),
        metrica("Moda (Empírica)", fmt(moda_empirica, 4)),
    ]

    pasos = [
        f"1. Media Agrupada: x̄ = Σ(Pm · f) / n = {fmt(suma_pm_f, 2)} / {fmt(n)} = {fmt(media, 4)}",
        f"2. Mediana Agrupada (clase {partes_int[idx_md]}, n/2 = {fmt(mitad)}): Md = {fmt(li_md)} + {fmt(i_md)} · [({fmt(mitad)} - {fmt(faa_md)}) / {fmt(f_md)}] = {fmt(mediana, 4)}",
        f"3a. Moda (Método Punto Medio, clase {partes_int[idx_mo]}): Mo = {fmt(moda_pm, 4)}",
        f"3b. Moda (Interpolación, Δ₁={fmt(delta1)}, Δ₂={fmt(delta2)}): Mo = {fmt(li_mo)} + {fmt(i_mo)} · [{fmt(delta1)} / ({fmt(delta1)} + {fmt(delta2)})] = {fmt(moda_interp, 4)}",
        f"3c. Moda (Método Empírico): Mo = 3({fmt(mediana, 2)}) - 2({fmt(media, 2)}) = {fmt(moda_empirica, 4)}",
    ]

    interpretacion = (
        f"Para los {fmt(n)} datos agrupados, la media aritmética es {fmt(media, 2)}, la mediana es {fmt(mediana, 2)} "
        f"y la moda por interpolación es {fmt(moda_interp, 2)} (punto medio: {fmt(moda_pm, 2)}, empírica: {fmt(moda_empirica, 2)})."
    )

    return construir_resultado(
        titulo="Medidas de Tendencia Central (Serie Agrupada)",
        etiqueta="Media Agrupada (x̄)",
        valor=fmt(media, 4),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=guardar_figura(fig, "u1", "tendencia_agrupada"),
    )

# ---------------------------------------------------------------------------
# 4. Medidas de Posición: Cuartiles (Q1..Q3) y Deciles (D1..D9)
# ---------------------------------------------------------------------------
def _posicion(params: dict) -> dict:
    tipo = a_texto(params.get("tipo_datos"), "no_agrupados").lower()
    medida = a_texto(params.get("medida"), "Q").upper()
    if medida not in {"Q", "D"}:
        fallo("La medida debe ser 'Q' (Cuartiles) o 'D' (Deciles).")

    max_k = 3 if medida == "Q" else 9
    divisor = 4 if medida == "Q" else 10
    nombre_medida = "Cuartil" if medida == "Q" else "Decil"
    k = int(a_numero(params.get("k"), f"número de {nombre_medida.lower()}", entero=True, minimo=1, maximo=max_k))

    # -----------------------------------------------------------------------
    # MODO 1: SERIE SIMPLE (DATOS NO AGRUPADOS)
    # -----------------------------------------------------------------------
    if tipo == "no_agrupados":
        datos = parsear_lista(params.get("datos"), "datos brutos")
        n = len(datos)
        if n < 2:
            fallo("Ingresa al menos 2 datos numéricos para calcular medidas de posición.")

        ordenados = sorted(datos)

        def calc_simple(idx_k: int) -> tuple[float, float, str]:
            pos = idx_k * (n + 1) / divisor
            if pos <= 1.0:
                val = ordenados[0]
                detalle = f"Posición {fmt(pos)} ≤ 1 → valor mínimo = {fmt(val)}"
            elif pos >= float(n):
                val = ordenados[-1]
                detalle = f"Posición {fmt(pos)} ≥ {n} → valor máximo = {fmt(val)}"
            else:
                entero = int(math.floor(pos))
                frac = pos - entero
                v_inf = ordenados[entero - 1]
                v_sup = ordenados[entero]
                val = v_inf + frac * (v_sup - v_inf)
                if frac == 0:
                    detalle = f"Posición exacta {entero} → {fmt(val)}"
                else:
                    detalle = (
                        f"Posición {fmt(pos)} → {fmt(v_inf)} + {fmt(frac, 4)} · ({fmt(v_sup)} - {fmt(v_inf)}) = {fmt(val, 4)}"
                    )
            return pos, val, detalle

        pos_sel, val_sel, detalle_sel = calc_simple(k)

        filas = []
        for idx_k in range(1, max_k + 1):
            p_i, v_i, _ = calc_simple(idx_k)
            porc = int((idx_k / divisor) * 100)
            filas.append([f"{medida}{idx_k}", f"{porc}%", fmt(p_i, 4), fmt(v_i, 4)])

        tabla = {
            "columnas": ["Medida", "Porcentaje acumulado", "Posición N = k(n+1)/" + str(divisor), "Valor calculado"],
            "filas": filas,
        }

        configurar_estilo()
        fig, ax = plt.subplots(figsize=(9.0, 4.3))
        x_pos = list(range(1, n + 1))
        ax.plot(x_pos, ordenados, color=COLOR_CYAN, marker="o", linewidth=2, label="Datos ordenados")
        ax.axhline(val_sel, color=COLOR_GREEN, linestyle="--", linewidth=2.2, label=f"{medida}{k} = {fmt(val_sel, 2)}")
        ax.set_xlabel("Posición del dato ordenado")
        ax.set_ylabel("Valor")
        ax.set_title(f"Ubicación de {medida}{k} en Serie Simple", pad=14)
        ax.grid(True, color="#1e293b", linestyle="--", alpha=0.6)
        ax.legend(loc="upper left")

        metricas = [
            metrica("Total datos (n)", str(n)),
            metrica(f"Posición N{k}", fmt(pos_sel, 4)),
            metrica(f"Valor {medida}{k}", fmt(val_sel, 4)),
            metrica("Porcentaje debajo", f"{int((k / divisor) * 100)}%"),
        ]

        pasos = [
            f"Serie ordenada ({n} datos): [{', '.join(fmt(x) for x in ordenados)}]",
            f"Fórmula de posición: N{k} = {k}({n} + 1) / {divisor} = {fmt(pos_sel, 4)}",
            f"Interpolación: {detalle_sel}",
        ]

        interpretacion = (
            f"El {nombre_medida.lower()} {medida}{k} = {fmt(val_sel, 4)} indica que aproximadamente el "
            f"{int((k / divisor) * 100)}% de las observaciones ordenadas son menores o iguales a este valor."
        )

        return construir_resultado(
            titulo=f"{nombre_medida}es en Serie Simple ({medida}{k})",
            etiqueta=f"{medida}{k}",
            valor=fmt(val_sel, 4),
            formato="texto",
            metricas=metricas,
            pasos=pasos,
            interpretacion=interpretacion,
            tabla=tabla,
            grafico_url=guardar_figura(fig, "u1", f"posicion_simple_{medida}{k}"),
        )

    # -----------------------------------------------------------------------
    # MODO 2: SERIE AGRUPADA (CLASES Y FRECUENCIAS)
    # -----------------------------------------------------------------------
    raw_int = a_texto(params.get("intervalos"), "")
    partes_int = [p.strip() for p in raw_int.split(",") if p.strip()]
    frecuencias = parsear_lista(params.get("frecuencias"), "frecuencias absolutas (f)")

    if len(partes_int) < 2 or len(partes_int) != len(frecuencias):
        fallo("Ingresa al menos 2 intervalos (ej: 2-4, 4-6) y la misma cantidad de frecuencias.")

    lim_infs = []
    lim_sups = []
    for p in partes_int:
        if "-" not in p:
            fallo(f"El intervalo '{p}' debe tener formato 'Li - Ls' (ej: 4 - 6).")
        trozos = [t.strip() for t in p.split("-") if t.strip()]
        if len(trozos) != 2:
            fallo(f"Formato inválido en el intervalo '{p}'.")
        li, ls = float(trozos[0]), float(trozos[1])
        if ls <= li:
            fallo(f"En el intervalo '{p}', el límite superior debe ser mayor al inferior.")
        lim_infs.append(li)
        lim_sups.append(ls)

    if any(f < 0 for f in frecuencias):
        fallo("Las frecuencias no pueden ser negativas.")

    n = sum(frecuencias)
    if n <= 0:
        fallo("La suma de las frecuencias (n) debe ser mayor que 0.")

    fas = []
    acum = 0.0
    for f in frecuencias:
        acum += f
        fas.append(acum)

    def calc_agrupado(idx_k: int) -> tuple[float, float, int, float, float, float, float]:
        no_pos = (idx_k * n) / divisor
        idx_clase = 0
        for i, fa in enumerate(fas):
            if fa >= no_pos:
                idx_clase = i
                break
        li = lim_infs[idx_clase]
        amp = lim_sups[idx_clase] - lim_infs[idx_clase]
        faa = fas[idx_clase - 1] if idx_clase > 0 else 0.0
        f_clase = frecuencias[idx_clase]
        val = li + amp * ((no_pos - faa) / f_clase) if f_clase > 0 else li
        return no_pos, val, idx_clase, li, amp, faa, f_clase

    no_sel, val_sel, idx_sel, li_sel, amp_sel, faa_sel, f_sel = calc_agrupado(k)

    filas = []
    for idx_k in range(1, max_k + 1):
        no_i, v_i, c_i, _, _, _, _ = calc_agrupado(idx_k)
        porc = int((idx_k / divisor) * 100)
        filas.append([f"{medida}{idx_k}", f"{porc}%", fmt(no_i, 4), partes_int[c_i], fmt(v_i, 4)])

    tabla = {
        "columnas": ["Medida", "Porcentaje", f"Número de orden No = k·n/{divisor}", "Clase que lo contiene", "Valor calculado"],
        "filas": filas,
    }

    configurar_estilo()
    fig, ax = plt.subplots(figsize=(9.2, 4.5))
    x_pos = list(range(len(partes_int)))
    colores_barras = [COLOR_GREEN if i == idx_sel else "#334155" for i in range(len(partes_int))]
    ax.bar(x_pos, frecuencias, width=0.92, color=colores_barras, edgecolor=COLOR_BG)
    ax.set_xticks(x_pos)
    ax.set_xticklabels(partes_int, rotation=15, ha="right")
    ax.set_ylabel("Frecuencia (f)")
    ax.set_title(f"Intervalo que contiene a {medida}{k} ({partes_int[idx_sel]})", pad=14)
    ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)

    metricas = [
        metrica("Total datos (n)", fmt(n)),
        metrica(f"Número de orden (No)", fmt(no_sel, 4)),
        metrica("Clase localizada", partes_int[idx_sel]),
        metrica(f"Valor {medida}{k}", fmt(val_sel, 4)),
    ]

    pasos = [
        f"1. Número de orden: No = ({k} · {fmt(n)}) / {divisor} = {fmt(no_sel, 4)}",
        f"2. Se ubica el primer Fa ≥ {fmt(no_sel, 4)}, que corresponde a la clase {partes_int[idx_sel]} (Fa = {fmt(fas[idx_sel])}).",
        f"3. Valores: Li = {fmt(li_sel)}, i = {fmt(amp_sel)}, Faa = {fmt(faa_sel)}, f = {fmt(f_sel)}",
        f"4. Fórmula: {medida}{k} = {fmt(li_sel)} + {fmt(amp_sel)} · [({fmt(no_sel, 4)} - {fmt(faa_sel)}) / {fmt(f_sel)}] = {fmt(val_sel, 4)}",
    ]

    interpretacion = (
        f"Debajo de {medida}{k} = {fmt(val_sel, 4)} se concentra el {int((k / divisor) * 100)}% de los datos "
        f"agrupados, ubicado dentro del intervalo {partes_int[idx_sel]}."
    )

    return construir_resultado(
        titulo=f"{nombre_medida}es en Serie Agrupada ({medida}{k})",
        etiqueta=f"{medida}{k}",
        valor=fmt(val_sel, 4),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=guardar_figura(fig, "u1", f"posicion_agrupada_{medida}{k}"),
    )

    # ---------------------------------------------------------------------------
# 5. Medidas de Dispersión: Dm, Desviación Estándar (σ), Varianza (S) y CV
# ---------------------------------------------------------------------------
def _interpretar_cv(cv: float) -> str:
    if cv < 10.0:
        return "De 0 a menos de 10%: Media altamente representativa."
    if cv < 20.0:
        return "De 10 a menos de 20%: Media bastante representativa."
    if cv < 30.0:
        return "De 20 a menos de 30%: Tiene representatividad."
    if cv < 40.0:
        return "De 30 a menos de 40%: Representatividad dudosa."
    return "40% o más: Carente de representatividad."


def _dispersion(params: dict) -> dict:
    tipo = a_texto(params.get("tipo_datos"), "no_agrupados").lower()

    # -----------------------------------------------------------------------
    # MODO 1: DATOS NO AGRUPADOS (SERIE SIMPLE)
    # -----------------------------------------------------------------------
    if tipo == "no_agrupados":
        datos = parsear_lista(params.get("datos"), "datos brutos")
        n = len(datos)
        if n < 2:
            fallo("Ingresa al menos 2 datos numéricos para calcular las medidas de dispersión.")

        media = sum(datos) / n
        if media == 0:
            fallo("La media aritmética es 0; no se puede calcular el Coeficiente de Variabilidad (división entre cero).")

        desv_abs = [abs(x - media) for x in datos]
        desv_cuad = [(x - media) ** 2 for x in datos]

        suma_abs = sum(desv_abs)
        suma_cuad = sum(desv_cuad)

        dm = suma_abs / n
        varianza = suma_cuad / n
        sigma = math.sqrt(varianza)
        cv = (sigma / abs(media)) * 100.0
        diagnostico_cv = _interpretar_cv(cv)

        filas = []
        for x, da, dc in zip(datos, desv_abs, desv_cuad):
            filas.append([fmt(x), fmt(x - media, 4), fmt(da, 4), fmt(dc, 4)])
        filas.append(["Total (Σ)", "0", fmt(suma_abs, 4), fmt(suma_cuad, 4)])

        tabla = {
            "columnas": ["Dato (x)", "x - x̄", "|x - x̄|", "(x - x̄)²"],
            "filas": filas,
        }

        configurar_estilo()
        fig, ax = plt.subplots(figsize=(9.0, 4.4))
        x_pos = list(range(1, n + 1))
        ax.plot(x_pos, datos, color=COLOR_CYAN, marker="o", linewidth=2, label="Datos (x)")
        ax.axhline(media, color=COLOR_GREEN, linestyle="--", linewidth=2, label=f"Media (x̄) = {fmt(media, 2)}")
        ax.axhspan(media - sigma, media + sigma, color=COLOR_GREEN, alpha=0.15, label=f"±1σ ({fmt(media - sigma, 2)} a {fmt(media + sigma, 2)})")
        ax.set_xlabel("Observación")
        ax.set_ylabel("Valor")
        ax.set_title("Dispersión respecto a la Media (Serie Simple)", pad=14)
        ax.grid(True, color="#1e293b", linestyle="--", alpha=0.6)
        ax.legend(loc="upper left")

        metricas = [
            metrica("Media (x̄)", fmt(media, 4)),
            metrica("Desviación Media (Dm)", fmt(dm, 4)),
            metrica("Varianza (S = σ²)", fmt(varianza, 4)),
            metrica("Desv. Estándar (σ)", fmt(sigma, 4)),
            metrica("Coef. Variabilidad (CV)", f"{fmt(cv, 2)}%"),
        ]

        pasos = [
            f"1. Media Aritmética: x̄ = Σx / n = {fmt(sum(datos))} / {n} = {fmt(media, 4)}",
            f"2. Desviación Media: Dm = Σ|x - x̄| / n = {fmt(suma_abs, 4)} / {n} = {fmt(dm, 4)}",
            f"3. Varianza: S = σ² = Σ(x - x̄)² / n = {fmt(suma_cuad, 4)} / {n} = {fmt(varianza, 4)}",
            f"4. Desviación Estándar: σ = √{fmt(varianza, 4)} = {fmt(sigma, 4)}",
            f"5. Coeficiente de Variabilidad: CV = (σ / x̄) · 100 = ({fmt(sigma, 4)} / {fmt(media, 4)}) · 100 = {fmt(cv, 2)}%",
        ]

        interpretacion = f"Con un CV = {fmt(cv, 2)}%, el diagnóstico según la tabla es: {diagnostico_cv}"

        return construir_resultado(
            titulo="Medidas de Dispersión (Serie Simple)",
            etiqueta="Desv. Estándar (σ)",
            valor=fmt(sigma, 4),
            formato="texto",
            metricas=metricas,
            pasos=pasos,
            interpretacion=interpretacion,
            tabla=tabla,
            grafico_url=guardar_figura(fig, "u1", "dispersion_simple"),
        )

    # -----------------------------------------------------------------------
    # MODO 2: DATOS AGRUPADOS (CLASES Y FRECUENCIAS)
    # -----------------------------------------------------------------------
    raw_int = a_texto(params.get("intervalos"), "")
    partes_int = [p.strip() for p in raw_int.split(",") if p.strip()]
    frecuencias = parsear_lista(params.get("frecuencias"), "frecuencias absolutas (f)")

    if len(partes_int) < 2 or len(partes_int) != len(frecuencias):
        fallo("Ingresa al menos 2 intervalos (ej: 5-7, 7-9) y la misma cantidad de frecuencias.")

    lim_infs = []
    lim_sups = []
    for p in partes_int:
        if "-" not in p:
            fallo(f"El intervalo '{p}' debe tener formato 'Li - Ls' (ej: 5 - 7).")
        trozos = [t.strip() for t in p.split("-") if t.strip()]
        if len(trozos) != 2:
            fallo(f"Formato inválido en el intervalo '{p}'.")
        li, ls = float(trozos[0]), float(trozos[1])
        if ls <= li:
            fallo(f"En el intervalo '{p}', el límite superior debe ser mayor al inferior.")
        lim_infs.append(li)
        lim_sups.append(ls)

    if any(f < 0 for f in frecuencias):
        fallo("Las frecuencias no pueden ser negativas.")

    n = sum(frecuencias)
    if n <= 0:
        fallo("La suma de las frecuencias (n) debe ser mayor que 0.")

    pms = [(li + ls) / 2.0 for li, ls in zip(lim_infs, lim_sups)]
    pm_f = [pm * f for pm, f in zip(pms, frecuencias)]
    suma_pm_f = sum(pm_f)
    media = suma_pm_f / n

    if media == 0:
        fallo("La media aritmética es 0; no se puede calcular el Coeficiente de Variabilidad.")

    abs_f = [abs(pm - media) * f for pm, f in zip(pms, frecuencias)]
    cuad_f = [((pm - media) ** 2) * f for pm, f in zip(pms, frecuencias)]

    suma_abs_f = sum(abs_f)
    suma_cuad_f = sum(cuad_f)

    dm = suma_abs_f / n
    varianza = suma_cuad_f / n
    sigma = math.sqrt(varianza)
    cv = (sigma / abs(media)) * 100.0
    diagnostico_cv = _interpretar_cv(cv)

    filas = []
    for p, f, pm, pf, af, cf in zip(partes_int, frecuencias, pms, pm_f, abs_f, cuad_f):
        filas.append([p, fmt(f), fmt(pm, 2), fmt(pf, 2), fmt(af, 2), fmt(cf, 2)])
    filas.append(["Total", fmt(n), "—", fmt(suma_pm_f, 2), fmt(suma_abs_f, 2), fmt(suma_cuad_f, 2)])

    tabla = {
        "columnas": ["Clases", "f", "Pm", "Pm · f", "|Pm - x̄| · f", "(Pm - x̄)² · f"],
        "filas": filas,
    }

    configurar_estilo()
    fig, ax = plt.subplots(figsize=(9.2, 4.5))
    x_pos = list(range(len(partes_int)))
    ax.bar(x_pos, frecuencias, width=0.92, color=COLOR_BLUE, edgecolor=COLOR_BG, alpha=0.85, label="Frecuencia (f)")
    ax.set_xticks(x_pos)
    ax.set_xticklabels(partes_int, rotation=15, ha="right")
    ax.set_ylabel("Frecuencia (f)")
    ax.set_title(f"Distribución Agrupada (x̄ = {fmt(media, 2)}, σ = {fmt(sigma, 2)})", pad=14)
    ax.grid(axis="y", color="#1e293b", linestyle="--", alpha=0.6)

    metricas = [
        metrica("Total datos (n)", fmt(n)),
        metrica("Media (x̄)", fmt(media, 4)),
        metrica("Desviación Media (Dm)", fmt(dm, 4)),
        metrica("Varianza (S = σ²)", fmt(varianza, 4)),
        metrica("Desv. Estándar (σ)", fmt(sigma, 4)),
        metrica("Coef. Variabilidad (CV)", f"{fmt(cv, 2)}%"),
    ]

    pasos = [
        f"1. Media Agrupada: x̄ = Σ(Pm · f) / n = {fmt(suma_pm_f, 2)} / {fmt(n)} = {fmt(media, 4)}",
        f"2. Desviación Media: Dm = Σ|Pm - x̄|·f / n = {fmt(suma_abs_f, 2)} / {fmt(n)} = {fmt(dm, 4)}",
        f"3. Varianza: S = σ² = Σ(Pm - x̄)²·f / n = {fmt(suma_cuad_f, 2)} / {fmt(n)} = {fmt(varianza, 4)}",
        f"4. Desviación Estándar: σ = √{fmt(varianza, 4)} = {fmt(sigma, 4)}",
        f"5. Coeficiente de Variabilidad: CV = ({fmt(sigma, 4)} / {fmt(media, 4)}) · 100 = {fmt(cv, 2)}%",
    ]

    interpretacion = f"Con un CV = {fmt(cv, 2)}%, el diagnóstico según la tabla es: {diagnostico_cv}"

    return construir_resultado(
        titulo="Medidas de Dispersión (Serie Agrupada)",
        etiqueta="Desv. Estándar (σ)",
        valor=fmt(sigma, 4),
        formato="texto",
        metricas=metricas,
        pasos=pasos,
        interpretacion=interpretacion,
        tabla=tabla,
        grafico_url=guardar_figura(fig, "u1", "dispersion_agrupada"),
    )



# ---------------------------------------------------------------------------
# Enrutador de acciones de la Unidad 1
# ---------------------------------------------------------------------------
ACCIONES = {
    "u1_tabla_frecuencia": _tabla_frecuencia,
    "u1_graficos": _graficos,
    "u1_tendencia_central": _tendencia_central,
    "u1_posicion": _posicion,
    "u1_dispersion": _dispersion
}

def main() -> None:
    payload = leer_payload()
    accion = a_texto(payload.get("action"))
    manejador = ACCIONES.get(accion)
    if manejador is None:
        fallo(f"Acción no reconocida por el procesador de la Unidad 1: {accion}")

    params = obtener_params(payload)
    try:
        resultado = manejador(params)
    except SystemExit:
        raise
    except Exception as exc:
        import sys
        import traceback

        traceback.print_exc(file=sys.stderr)
        fallo(f"Error interno del motor de la Unidad 1: {exc}")

    responder({"ok": True, "resultado": resultado})


if __name__ == "__main__":
    main()
