<div id="splash-screen" class="fixed inset-0 z-50 flex items-center justify-center bg-bg-primary transition-opacity duration-500">
    <div class="text-center animate-pulse">
        <img src="{{ asset('images/logo_gambeta.png') }}" alt="Gambeta Logo" class="w-48 h-48 mx-auto mb-4 object-contain">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const splash = document.getElementById('splash-screen');
        if (splash) {
            setTimeout(() => {
                splash.classList.add('opacity-0');
                setTimeout(() => {
                    splash.remove();
                }, 500);
            }, 2000); // mostrar por 2 segundos
        }
    });
</script>
