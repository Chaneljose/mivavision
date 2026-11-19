<?php
require_once('cnx/cnx_conexion.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="MIVAVISION - Camaras de seguridad y videovigilancia. Equipos Dahua, IMOU y TP-Link Tapo. Instalacion y asesoria incluida.">
  <meta name="author" content="MIVAVISION">
  <link rel="shortcut icon" href="Iconos/favicon.ico">
  <title>MIVAVISION - Camaras de seguridad y videovigilancia</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f7fbe8',
              100: '#eef7c8',
              200: '#dff09b',
              300: '#cbe85f',
              400: '#b6e802',
              500: '#9fc908',
              600: '#7ba006',
              700: '#5c7a08',
              800: '#455c0c',
              900: '#3a4c10',
              950: '#1e2903'
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif']
          }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    html {
      scroll-behavior: smooth;
    }

    .hero-overlay {
      background:
        linear-gradient(90deg, rgba(30, 41, 3, .92) 0%, rgba(30, 41, 3, .75) 45%, rgba(30, 41, 3, .35) 100%);
    }

    /* En móvil el texto va centrado: overlay vertical para mantener el contraste */
    @media (max-width: 640px) {
      .hero-overlay {
        background:
          linear-gradient(180deg, rgba(30, 41, 3, .70) 0%, rgba(30, 41, 3, .88) 55%, rgba(30, 41, 3, .75) 100%);
      }
    }

    .brand-glow {
      box-shadow: 0 10px 40px -10px rgba(159, 201, 8, .55);
    }
  </style>
</head>

<body class="font-sans bg-slate-50 text-slate-800 antialiased">

  <!-- ===================== NAVBAR ===================== -->
  <header class="fixed top-0 inset-x-0 z-50 bg-brand-950/90 backdrop-blur border-b border-brand-800/50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <a href="#" class="flex items-center gap-2">
          <!--<span class="grid place-items-center h-9 w-9 rounded-lg bg-brand-400 text-brand-950 font-extrabold">M</span>
            <span class="text-white font-extrabold tracking-wide text-lg">MIVA<span class="text-brand-400">VISION</span></span>-->
          <img src="Iconos/logo_web_MIVAVISION_transparente_slogan_blanco.png" width="200" height="100" alt="MIVAVISION camaras de seguridad">
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-200">
          <a href="#inicio" class="hover:text-brand-400 transition">Inicio</a>
          <a href="#productos" class="hover:text-brand-400 transition">Productos</a>
          <a href="#servicios" class="hover:text-brand-400 transition">Servicios</a>
          <a href="#contacto" class="hover:text-brand-400 transition">Contacto</a>
        </div>

        <div class="flex items-center gap-3">
          <button type="button" onclick="document.getElementById('login-modal').classList.remove('hidden')"
            class="hidden sm:inline-flex items-center gap-2 rounded-lg bg-brand-400 px-4 py-2 text-sm font-semibold text-brand-950 hover:bg-brand-300 transition brand-glow">
            Iniciar sesion
          </button>
          <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
            class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-lg text-white hover:bg-brand-800 transition" aria-label="Menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
      <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-1 text-slate-200">
        <a href="#inicio" class="block px-3 py-2 rounded-lg hover:bg-brand-800">Inicio</a>
        <a href="#productos" class="block px-3 py-2 rounded-lg hover:bg-brand-800">Productos</a>
        <a href="#servicios" class="block px-3 py-2 rounded-lg hover:bg-brand-800">Servicios</a>
        <a href="#contacto" class="block px-3 py-2 rounded-lg hover:bg-brand-800">Contacto</a>
        <button type="button" onclick="document.getElementById('login-modal').classList.remove('hidden')"
          class="w-full mt-2 rounded-lg bg-brand-400 px-4 py-2 text-sm font-semibold text-brand-950">Iniciar sesion</button>
      </div>
    </nav>
  </header>

  <!-- ===================== HERO / PORTADA ===================== -->
  <section id="inicio" class="relative min-h-screen flex items-center pt-16">
    <!-- Imagen de portada: versión móvil (<= 640px) y versión escritorio -->
    <picture class="absolute inset-0">
      <source media="(max-width: 640px)" srcset="Iconos/portada_para_fondo_movil.png">
      <img src="Iconos/portada_para_letrero_modificado_web.png" alt="MIVAVISION camaras de seguridad"
        class="h-full w-full object-cover object-[50%_35%] sm:object-center"
        fetchpriority="high" decoding="async">
    </picture>
    <div class="absolute inset-0 hero-overlay"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 w-full text-center sm:text-left">
      <div class="max-w-2xl mx-auto sm:mx-0">
        <span class="inline-flex items-center gap-2 rounded-full bg-brand-400/15 border border-brand-400/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-brand-300">
          <span class="h-2 w-2 rounded-full bg-brand-400 animate-pulse"></span>
          Videovigilancia profesional
        </span>

        <h1 class="mt-4 sm:mt-6 text-3xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-white">
          Protege lo que mas te importa con
          <span class="text-brand-400">camaras de seguridad</span>
        </h1>

        <p class="mt-4 sm:mt-6 text-base sm:text-lg text-slate-200 max-w-md sm:max-w-xl mx-auto sm:mx-0">
          Equipos Dahua, IMOU y TP-Link Tapo para tu hogar, negocio u oficina.
          Instalacion, configuracion y asesoria incluida de principio a fin.
        </p>

        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row flex-wrap justify-center sm:justify-start gap-3 sm:gap-4">
          <a href="#productos"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-400 px-6 py-3.5 text-base font-semibold text-brand-950 hover:bg-brand-300 transition brand-glow">
            Ver productos
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
          <a href="#contacto"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 bg-white/5 px-6 py-3.5 text-base font-semibold text-white hover:bg-white/15 transition">
            Solicitar cotizacion
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== MARCAS ===================== -->
  <section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">Trabajamos con las mejores marcas</p>
      <div class="mt-4 flex flex-wrap items-center justify-center gap-x-12 gap-y-4 text-lg font-bold text-slate-400">
        <span class="hover:text-brand-600 transition">Dahua</span>
        <span class="hover:text-brand-600 transition">IMOU</span>
        <span class="hover:text-brand-600 transition">TP-Link Tapo</span>
        <span class="hover:text-brand-600 transition">Western Digital</span>
      </div>
    </div>
  </section>

  <!-- ===================== PRODUCTOS ===================== -->
  <section id="productos" class="py-20 bg-slate-50 scroll-mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Nuestros productos</h2>
        <p class="mt-4 text-slate-500">Camaras, grabadores y accesorios de videovigilancia seleccionados para cada necesidad.</p>
      </div>

      <!-- Filtros: marca, categoria, stock y orden -->
      <div class="mt-12 space-y-4">
        <div class="flex flex-col gap-3">
          <span class="text-sm font-medium text-slate-500">Marca</span>
          <div id="filtro-marcas" class="flex flex-wrap gap-2" role="group" aria-label="Filtrar por marca"></div>
        </div>
        <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end sm:justify-between">
          <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end">
            <div class="flex flex-col gap-1.5">
              <label for="filtro-categoria" class="text-sm font-medium text-slate-500">Categoría</label>
              <select id="filtro-categoria"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 focus:outline-none">
              </select>
            </div>
            <div class="flex flex-col gap-1.5">
              <label for="filtro-stock" class="text-sm font-medium text-slate-500">Stock</label>
              <select id="filtro-stock"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 focus:outline-none">
                <option value="Todos">Todos</option>
                <option value="Disponible">Disponible</option>
                <option value="Agotado">Agotado</option>
              </select>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <label for="orden-productos" class="text-sm font-medium text-slate-500 whitespace-nowrap">Ordenar por</label>
            <select id="orden-productos"
              class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 focus:outline-none">
              <option value="relevancia">Relevancia</option>
              <option value="precio-asc">Precio: menor a mayor</option>
              <option value="precio-desc">Precio: mayor a menor</option>
              <option value="nombre-asc">Nombre: A - Z</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Contador de resultados -->
      <p id="productos-contador" class="mt-4 text-sm text-slate-400"></p>

      <!-- Grid de productos (renderizado por JavaScript) -->
      <div id="productos-grid" class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"></div>

      <!-- Sin resultados -->
      <p id="productos-vacio" class="hidden mt-12 text-center text-slate-500">No se encontraron productos con ese filtro.</p>

      <!-- Paginacion -->
      <nav id="productos-paginacion" class="mt-12 flex flex-wrap items-center justify-center gap-2" aria-label="Paginacion de productos"></nav>
    </div>
  </section>

  <!-- ===================== SERVICIOS ===================== -->
  <section id="servicios" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Nuestros servicios</h2>
        <p class="mt-4 text-slate-500">Soluciones completas de seguridad, desde la asesoria hasta el mantenimiento.</p>
      </div>

      <div class="mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-8 hover:border-brand-300 hover:bg-brand-50 transition">
          <div class="grid place-items-center h-12 w-12 rounded-xl bg-brand-500 text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="mt-5 font-bold text-slate-900 text-lg">Instalacion de camaras</h3>
          <p class="mt-2 text-sm text-slate-500">Montaje profesional de camaras IP, WiFi y HDCVI, con cableado y configuracion incluida.</p>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-8 hover:border-brand-300 hover:bg-brand-50 transition">
          <div class="grid place-items-center h-12 w-12 rounded-xl bg-brand-500 text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <h3 class="mt-5 font-bold text-slate-900 text-lg">Seguridad y monitoreo</h3>
          <p class="mt-2 text-sm text-slate-500">Acceso remoto desde tu celular, alertas en tiempo real y grabacion en la nube o local.</p>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-8 hover:border-brand-300 hover:bg-brand-50 transition">
          <div class="grid place-items-center h-12 w-12 rounded-xl bg-brand-500 text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          <h3 class="mt-5 font-bold text-slate-900 text-lg">Mantenimiento</h3>
          <p class="mt-2 text-sm text-slate-500">Limpieza, ajustes y soporte tecnico para que tu sistema funcione siempre al 100%.</p>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-8 hover:border-brand-300 hover:bg-brand-50 transition">
          <div class="grid place-items-center h-12 w-12 rounded-xl bg-brand-500 text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
          </div>
          <h3 class="mt-5 font-bold text-slate-900 text-lg">Asesoria personalizada</h3>
          <p class="mt-2 text-sm text-slate-500">Te ayudamos a elegir el equipo ideal segun el espacio, el presupuesto y tus necesidades.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== CTA / CONTACTO ===================== -->
  <section id="contacto" class="py-20 bg-brand-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="rounded-3xl bg-gradient-to-br from-brand-600 to-brand-800 px-8 py-14 sm:px-14 text-center brand-glow">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Cotiza tu sistema de videovigilancia</h2>
        <p class="mt-4 text-brand-50 max-w-2xl mx-auto">
          Precios de referencia en dolares, sujetos a disponibilidad y cambios sin previo aviso.
          Contamos con kits completos de 4 y 8 camaras con instalacion incluida.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
          <a href="Sesion/Acceso.php"
            class="rounded-xl bg-brand-400 px-7 py-3.5 text-base font-semibold text-brand-950 hover:bg-brand-300 transition">
            Solicitar cotizacion
          </a>
          <a href="#productos"
            class="rounded-xl border border-white/40 px-7 py-3.5 text-base font-semibold text-white hover:bg-white/10 transition">
            Ver catalogo
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== FOOTER ===================== -->
  <footer class="bg-brand-950 border-t border-brand-800/50 text-slate-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid gap-8 md:grid-cols-3">
        <div>
          <div class="flex items-center gap-2">
            <!--<span class="grid place-items-center h-9 w-9 rounded-lg bg-brand-400 text-brand-950 font-extrabold">M</span>
              <span class="text-white font-extrabold tracking-wide text-lg">MIVA<span class="text-brand-400">VISION</span></span>-->
            <img src="Iconos/logo_web_MIVAVISION_transparente_slogan_blanco.png" width="200" height="100" alt="MIVAVISION camaras de seguridad">
          </div>
          <p class="mt-4 text-sm text-slate-400 max-w-xs">Camaras de seguridad y videovigilancia para hogar, negocio u oficina.</p>
        </div>
        <div>
          <h3 class="text-white font-semibold">Enlaces</h3>
          <ul class="mt-4 space-y-2 text-sm">
            <li><a href="#inicio" class="hover:text-brand-400 transition">Inicio</a></li>
            <li><a href="#productos" class="hover:text-brand-400 transition">Productos</a></li>
            <li><a href="#servicios" class="hover:text-brand-400 transition">Servicios</a></li>
            <li><a href="#contacto" class="hover:text-brand-400 transition">Contacto</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-white font-semibold">Acceso</h3>
          <ul class="mt-4 space-y-2 text-sm">
            <li>
              <button type="button" onclick="document.getElementById('login-modal').classList.remove('hidden')"
                class="hover:text-brand-400 transition">Iniciar sesion</button>
            </li>
            <li><a href="Sesion/Acceso.php" class="hover:text-brand-400 transition">Cotizar</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-10 border-t border-brand-800/50 pt-6 text-center text-sm text-slate-400">
        &copy; MIVAVISION - Camaras de seguridad y videovigilancia
      </div>
    </div>
  </footer>
  <!-- ===================== MODAL LOGIN ===================== -->
  <div id="login-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-brand-950/70 backdrop-blur-sm" onclick="document.getElementById('login-modal').classList.add('hidden')"></div>

    <div class="relative w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">
      <button type="button" onclick="document.getElementById('login-modal').classList.add('hidden')"
        class="absolute top-4 right-4 grid place-items-center h-8 w-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition" aria-label="Cerrar">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <h2 class="text-xl font-extrabold text-slate-900 text-center">Iniciar sesion</h2>
      <p class="mt-1 text-sm text-slate-500 text-center">Ingresa a tu cuenta MIVAVISION</p>

      <form class="mt-6 space-y-4" role="form" method="post" action="Sesion/Acceso.php">
        <div>
          <label for="USR" class="block text-sm font-medium text-slate-700">Usuario</label>
          <input type="text" id="USR" name="USR" required autofocus
            placeholder="USUARIO"
            onchange="this.value = this.value.toUpperCase();"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-200 focus:outline-none">
        </div>
        <div>
          <label for="PSWR" class="block text-sm font-medium text-slate-700">Clave</label>
          <input type="password" id="PSWR" name="PSWR" required
            placeholder="CLAVE"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-200 focus:outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600">
          <input type="checkbox" value="remember-me" id="recordarme" class="rounded border-slate-300 text-brand-500 focus:ring-brand-400">
          Recordarme
        </label>
        <button type="submit"
          class="w-full rounded-lg bg-brand-500 px-4 py-3 text-sm font-semibold text-white hover:bg-brand-600 transition">
          INGRESAR
        </button>
      </form>
    </div>
  </div>
  <!-- ===================== PRODUCTOS: filtros, orden y paginacion ===================== -->
  <script>
    // Datos de los productos
    const PRODUCTOS = [{
        nombre: 'Tapo C210',
        marca: 'TP-Link Tapo',
        categoria: 'Cámaras',
        stock: 'Disponible',
        precio: 29.99,
        img: 'imagenes/imagen_TAPO%20C210.png',
        alt: 'Camara WiFi Tapo C210',
        desc: 'Camara WiFi interior 360 grados, 3 MP, vision nocturna y audio bidireccional.'
      },
      {
        nombre: 'Tapo C310',
        marca: 'TP-Link Tapo',
        categoria: 'Cámaras',
        stock: 'Disponible',
        precio: 44.99,
        img: 'imagenes/imagen_TAPO%20C310.png',
        alt: 'Camara WiFi Tapo C310',
        desc: 'Camara WiFi exterior 3 MP, resistente al agua, vision nocturna y deteccion de movimiento.'
      },
      {
        nombre: 'IMOU IPC-K7FN',
        marca: 'IMOU',
        categoria: 'Cámaras',
        stock: 'Disponible',
        precio: 39.99,
        img: 'imagenes/imagen_IPC-K7FN-3H0WE-IMOU.png',
        alt: 'Camara WiFi IMOU IPC-K7FN',
        desc: 'Camara WiFi interior 3 MP con seguimiento inteligente y comunicacion de dos vias.'
      },
      {
        nombre: 'Dahua HAC-B1A21N',
        marca: 'Dahua',
        categoria: 'Cámaras',
        stock: 'Disponible',
        precio: 34.99,
        img: 'imagenes/imagen_DH-HAC-B1A21N-U-0280B.png',
        alt: 'Camara HDCVI Dahua B1A21N',
        desc: 'Camara tipo bala HDCVI 2 MP, lente 2.8 mm, ideal para exteriores con DVR.'
      },
      {
        nombre: 'Dahua IPC-H5AP',
        marca: 'Dahua',
        categoria: 'Cámaras',
        stock: 'Agotado',
        precio: 89.99,
        img: 'imagenes/imagen_DH-IPC-H5AP-0360B.png',
        alt: 'Camara IP Dahua IPC-H5AP',
        desc: 'Camara IP tipo domo 5 MP, lente 3.6 mm, alta definicion para interiores y comercios.'
      },
      {
        nombre: 'Dahua XVR5108HS-I3',
        marca: 'Dahua',
        categoria: 'Grabadores',
        stock: 'Disponible',
        precio: 149.99,
        img: 'imagenes/imagen_DH-XVR5108HS-I3(V3.0).png',
        alt: 'DVR Dahua XVR5108HS-I3',
        desc: 'Grabador DVR de 8 canales, soporta HDCVI, AHD, TVI, CVBS e IP, acceso remoto.'
      },
      {
        nombre: 'Dahua PFM800-E',
        marca: 'Dahua',
        categoria: 'Accesorios',
        stock: 'Disponible',
        precio: 14.99,
        img: 'imagenes/imagen_DH-PFM800-E.png',
        alt: 'Fuente de poder Dahua PFM800-E',
        desc: 'Fuente de poder para camaras y equipos de videovigilancia, instalacion sencilla.'
      },
      {
        nombre: 'WD Purple 1 TB',
        marca: 'Western Digital',
        categoria: 'Almacenamiento',
        stock: 'Agotado',
        precio: 59.99,
        img: 'imagenes/imagen_WD11PURZ.png',
        alt: 'Disco duro Western Digital Purple 1TB',
        desc: 'Disco duro para videovigilancia, optimizado para grabacion continua 24/7.'
      },
      {
        nombre: 'Memoria 64 GB',
        marca: 'Dahua',
        categoria: 'Almacenamiento',
        stock: 'Disponible',
        precio: 12.99,
        img: 'imagenes/imagen_DHI-TF-C100-64GB.png',
        alt: 'Memoria microSD Dahua 64GB',
        desc: 'Tarjeta microSD clase 10 para camaras WiFi, grabacion local de video.'
      }
    ];
    const POR_PAGINA = 6;
    const estado = {
      marca: 'Todas',
      categoria: 'Todas',
      stock: 'Todos',
      orden: 'relevancia',
      pagina: 1
    };
    const elFiltroMarcas = document.getElementById('filtro-marcas');
    const elFiltroCategoria = document.getElementById('filtro-categoria');
    const elFiltroStock = document.getElementById('filtro-stock');
    const elOrden = document.getElementById('orden-productos');
    const elGrid = document.getElementById('productos-grid');
    const elVacio = document.getElementById('productos-vacio');
    const elContador = document.getElementById('productos-contador');
    const elPaginacion = document.getElementById('productos-paginacion');
    const MARCAS = ['Todas'].concat(Array.from(new Set(PRODUCTOS.map(p => p.marca))));
    const CATEGORIAS = ['Todas'].concat(Array.from(new Set(PRODUCTOS.map(p => p.categoria))).sort(function(a, b) {
      return a.localeCompare(b, 'es');
    }));
    elFiltroCategoria.innerHTML = CATEGORIAS.map(function(c) {
      return '<option value="' + c + '">' + c + '</option>';
    }).join('');

    function botonMarca(marca) {
      const activo = marca === estado.marca;
      const clases = activo ?
        'bg-brand-500 border-brand-500 text-white' :
        'bg-white border-slate-200 text-slate-600 hover:border-brand-400 hover:text-brand-700';
      return '<button type="button" data-marca="' + marca + '" class="rounded-full border px-4 py-2 text-sm font-semibold transition ' + clases + '">' + marca + '</button>';
    }

    function productosFiltrados() {
      let lista = PRODUCTOS.filter(function(p) {
        const okMarca = estado.marca === 'Todas' || p.marca === estado.marca;
        const okCategoria = estado.categoria === 'Todas' || p.categoria === estado.categoria;
        const okStock = estado.stock === 'Todos' || p.stock === estado.stock;
        return okMarca && okCategoria && okStock;
      });
      lista = lista.slice();
      if (estado.orden === 'precio-asc') lista.sort(function(a, b) {
        return a.precio - b.precio;
      });
      if (estado.orden === 'precio-desc') lista.sort(function(a, b) {
        return b.precio - a.precio;
      });
      if (estado.orden === 'nombre-asc') lista.sort(function(a, b) {
        return a.nombre.localeCompare(b.nombre, 'es');
      });
      return lista;
    }

    function tarjeta(p) {
      var stockClases = p.stock === 'Disponible' ?
        'bg-emerald-50 text-emerald-700' :
        'bg-red-50 text-red-700';
      return '<article class="group bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">' +
        '<div class="aspect-[4/3] bg-slate-50 overflow-hidden">' +
        '<img src="' + p.img + '" alt="' + p.alt + '" loading="lazy" class="h-full w-full object-contain p-6 group-hover:scale-105 transition duration-300">' +
        '</div>' +
        '<div class="p-6">' +
        '<div class="flex flex-wrap items-center gap-2">' +
        '<span class="inline-block rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">' + p.marca + '</span>' +
        '<span class="inline-block rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">' + p.categoria + '</span>' +
        '<span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold ' + stockClases + '">' + p.stock + '</span>' +
        '</div>' +
        '<h3 class="mt-3 font-bold text-slate-900 text-lg">' + p.nombre + '</h3>' +
        '<p class="mt-2 text-sm text-slate-500">' + p.desc + '</p>' +
        '<div class="mt-4 flex items-center justify-between">' +
        '<p class="text-xl font-extrabold text-brand-600">$' + p.precio.toFixed(2) + ' <span class="text-xs font-medium text-slate-400">USD</span></p>' +
        '<a href="Sesion/Acceso.php" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600 transition">Comprar</a>' +
        '</div>' +
        '</div>' +
        '</article>';
    }

    function botonPagina(etiqueta, destino, activo, deshabilitado) {
      const clases = activo ?
        'bg-brand-500 border-brand-500 text-white' :
        'bg-white border-slate-200 text-slate-600 hover:border-brand-400 hover:text-brand-700';
      return '<button type="button" data-pagina="' + destino + '"' + (deshabilitado ? ' disabled' : '') +
        ' class="min-w-[2.5rem] rounded-lg border px-3 py-2 text-sm font-semibold transition ' + clases +
        (deshabilitado ? ' opacity-40 cursor-not-allowed' : '') + '">' + etiqueta + '</button>';
    }

    function render() {
      const lista = productosFiltrados();
      const totalPaginas = Math.max(1, Math.ceil(lista.length / POR_PAGINA));
      if (estado.pagina > totalPaginas) estado.pagina = totalPaginas;
      if (estado.pagina < 1) estado.pagina = 1;
      const inicio = (estado.pagina - 1) * POR_PAGINA;
      const visibles = lista.slice(inicio, inicio + POR_PAGINA);
      // Filtros de marca
      elFiltroMarcas.innerHTML = MARCAS.map(botonMarca).join('');
      // Grid
      elGrid.innerHTML = visibles.map(tarjeta).join('');
      elVacio.classList.toggle('hidden', lista.length !== 0);
      // Contador de resultados
      elContador.textContent = lista.length === 0 ?
        '' :
        'Mostrando ' + (inicio + 1) + '-' + (inicio + visibles.length) + ' de ' + lista.length + ' productos';
      // Paginacion
      if (lista.length === 0 || totalPaginas <= 1) {
        elPaginacion.innerHTML = '';
      } else {
        let html = botonPagina('&laquo;', estado.pagina - 1, false, estado.pagina === 1);
        for (let i = 1; i <= totalPaginas; i++) {
          html += botonPagina(i, i, i === estado.pagina, false);
        }
        html += botonPagina('&raquo;', estado.pagina + 1, false, estado.pagina === totalPaginas);
        elPaginacion.innerHTML = html;
      }
    }
    // Cambio de marca
    elFiltroMarcas.addEventListener('click', function(e) {
      var btn = e.target.closest('button[data-marca]');
      if (!btn) return;
      estado.marca = btn.dataset.marca;
      estado.pagina = 1;
      render();
    });
    // Cambio de categoria
    elFiltroCategoria.addEventListener('change', function() {
      estado.categoria = this.value;
      estado.pagina = 1;
      render();
    });
    // Cambio de stock
    elFiltroStock.addEventListener('change', function() {
      estado.stock = this.value;
      estado.pagina = 1;
      render();
    });
    // Cambio de pagina
    elPaginacion.addEventListener('click', function(e) {
      var btn = e.target.closest('button[data-pagina]');
      if (!btn || btn.disabled) return;
      estado.pagina = parseInt(btn.dataset.pagina, 10);
      render();
      document.getElementById('productos').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    });
    // Cambio de orden
    elOrden.addEventListener('change', function() {
      estado.orden = this.value;
      estado.pagina = 1;
      render();
    });
    render();
  </script>
</body>

</html>