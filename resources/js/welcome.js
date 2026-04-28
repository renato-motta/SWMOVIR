document.addEventListener("DOMContentLoaded", () => {

    /* =====================
       CONFIGURAR TEMA
    ====================== */
    const html = document.documentElement;
    // const saved = localStorage.getItem("theme") || "dark";

    let saved = localStorage.getItem("theme");

    // Si el usuario nunca eligió tema, usar el tema del sistema
    if (!saved) {
        const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        saved = prefersDark ? "dark" : "light";
    }

    html.setAttribute("data-theme", saved);
    const icon = document.getElementById("theme-icon");
    // document.getElementById("theme-icon").textContent = saved === "dark" ? "🌞" : "🌙";
    if (icon) {
        icon.textContent = saved === "dark" ? "🌞" : "🌙";
    }

    html.style.opacity = "1";

    /* =====================
       EFECTO CONFETTI
    ====================== */
    createConfetti();
    setTimeout(() => {
        const confettiCanvas = document.getElementById("confetti");
        if (confettiCanvas) confettiCanvas.remove();
    }, 5000);// Desaparece después de 5 segundos

    /* =====================
       ANIMACIÓN DE TARJETA
    ====================== */
    const card = document.querySelector(".glass-card");
    if (card) {
        card.style.opacity = 0;
        card.style.transform = "translateY(20px)";
        setTimeout(() => {
            card.style.transition = "0.5s ease";
            card.style.opacity = 1;
            card.style.transform = "translateY(0)";
        }, 80);
    }

});

/* =====================
   FUNCIÓN CAMBIAR TEMA
====================== */
window.toggleTheme = function () {
    const html = document.documentElement;
    const newTheme = html.getAttribute("data-theme") === "dark" ? "light" : "dark";

    html.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);

    // document.getElementById("theme-icon").textContent = newTheme === "dark" ? "🌞" : "🌙";
    const icon = document.getElementById("theme-icon");
    if (icon) {
        icon.textContent = newTheme === "dark" ? "🌞" : "🌙";
    }
};

/* =====================
   FUNCIÓN CONFETTI
====================== */
function createConfetti() {
    const canvas = document.createElement("canvas");
    canvas.id = "confetti";
    canvas.style.position = "fixed";
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = "100%";
    canvas.style.height = "100%";
    canvas.style.pointerEvents = "none";
    canvas.style.zIndex = 0;// Debajo de la tarjeta
    document.body.appendChild(canvas);

    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const confettis = [];
    for (let i = 0; i < 100; i++) {
        confettis.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            r: Math.random() * 6 + 4,
            d: Math.random() * 20 + 10,
            color: `hsl(${Math.random() * 360}, 70%, 60%)`,
            tilt: Math.random() * 10 - 10,
            tiltAngleIncrement: Math.random() * 0.07 + 0.05
        });
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        confettis.forEach(c => {
            ctx.beginPath();
            ctx.lineWidth = c.r / 2;
            ctx.strokeStyle = c.color;
            ctx.moveTo(c.x + c.tilt + c.r / 4, c.y);
            ctx.lineTo(c.x + c.tilt, c.y + c.tilt + c.r / 4);
            ctx.stroke();
        });

        update();
    }

    function update() {
        confettis.forEach(c => {
            c.y += Math.cos(c.d) + 3 + c.r / 2;
            c.x += Math.sin(c.d);
            c.tiltAngleIncrement += 0.01;
            c.tilt = Math.sin(c.tiltAngleIncrement) * 15;

            if (c.y > canvas.height) {
                c.x = Math.random() * canvas.width;
                c.y = -10;
            }
        });
    }

    const interval = setInterval(draw, 20);
    setTimeout(() => clearInterval(interval), 5000); // Stop after 5s
}

 {/* Esto hace que toggleTheme sea accesible desde HTML  window.toggleTheme = toggleTheme; */}
