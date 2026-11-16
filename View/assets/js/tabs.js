/* ==========================================================================
   Calculadora One Milion - Pestañas compartidas
   ========================================================================== */
(function () {
    'use strict';

    function switchTab(tabId) {
        var contenidos = document.querySelectorAll('.tab-content');
        var botones = document.querySelectorAll('.tab-button');

        contenidos.forEach(function (contenido) {
            contenido.classList.remove('active');
        });
        botones.forEach(function (boton) {
            boton.classList.remove('active');
        });

        var destino = document.getElementById(tabId);
        if (destino) {
            destino.classList.add('active');
        }

        var botonActivo = document.querySelector('.tab-button[data-tab="' + tabId + '"]');
        if (!botonActivo && botones.length > 0) {
            botonActivo = botones[tabId === 'practica' ? 1 : 0];
        }
        if (botonActivo) {
            botonActivo.classList.add('active');
        }
    }

    window.switchTab = switchTab;

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.tab-button[data-tab]').forEach(function (boton) {
            boton.addEventListener('click', function () {
                switchTab(boton.getAttribute('data-tab'));
            });
        });

        var params = new URLSearchParams(window.location.search);
        var tab = params.get('tab');
        if (!tab && window.location.hash) {
            tab = window.location.hash.replace('#', '');
        }
        if (tab && document.getElementById(tab)) {
            switchTab(tab);
        }
    });
})();
