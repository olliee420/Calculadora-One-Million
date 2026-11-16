<?php
/**
 * Cierre compartido de las páginas de las unidades con pie de página minimalista.
 */
?>
        <footer class="app-footer-mini">
            <span>&copy; <?php echo date('Y'); ?> <strong>Calculadora One Milion</strong> · Estadística y Probabilidad</span>
            <span class="footer-status"><span class="status-dot"></span> Motor Analítico Listo</span>
        </footer>
    </main>
</div>

<style>
    .app-footer-mini {
        margin-top: 3rem;
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.84rem;
        color: var(--text-secondary, #94a3b8);
    }

    .app-footer-mini strong {
        color: var(--text-primary, #f1f5f9);
    }

    .footer-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.8rem;
        color: var(--accent-neon-green, #00ffaa);
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: var(--accent-neon-green, #00ffaa);
        box-shadow: 0 0 6px var(--accent-neon-green, #00ffaa);
    }
</style>
</body>
</html>
