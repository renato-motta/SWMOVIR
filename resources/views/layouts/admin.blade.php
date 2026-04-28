@props([
  'title'=>config('app.name', 'Laravel'),
  'breadcrumbs' =>[]
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font awesome -->
        <script src="https://kit.fontawesome.com/46d059cb03.js" crossorigin="anonymous"></script>

        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- wire ui -->
        <wireui:scripts />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles -->
        @livewireStyles

        <!-- Styles -->
        @stack('css')

    </head>
    <body class="font-sans antialiased bg-gray-50">

      @include('layouts.includes.admin.navigation')
      @include('layouts.includes.admin.sidebar')

      <div class="p-4 sm:ml-64">
        <div class="mt-14 flex items-center">
            
            @include('layouts.includes.admin.breadcrumb')
            @isset($action)
              <div class="ml-auto">
                {{$action}}
              </div>
            @endisset

        </div>
        {{$slot}}
      </div>
        @stack('modals')
        
        @livewireScripts

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        <script>
            Livewire.on('swal', (data) => {
              Swal.fire(data[0]);
            });
        </script>

        @if (session('swal'))
            <script>
              Swal.fire(@json(session('swal')));
            </script>
        @endif

        <script>
            forms=document.querySelectorAll('.delete-form');
            
            forms.forEach(form =>{
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    //alert("se detuvo");
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "¡Sí, eliminar!",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {                 
                        if (result.isConfirmed){
                            form.submit();
                        }
                    });
                })
            });
        </script>

        {{-- stack:indicamos al laravel q vamos a colocar un contenido y ese contenido que vamos a indicar q lo reflejes en "js" --}}
        @stack('js')


        <!-- Script modo oscuro -->
        <script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    if (localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        lightIcon.classList.remove('hidden');
        document.documentElement.classList.add('dark');
    } else {
        darkIcon.classList.remove('hidden');
        document.documentElement.classList.remove('dark');
    }

    themeToggleBtn.addEventListener('click', function () {
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    });
</script>

    </body>
</html>
