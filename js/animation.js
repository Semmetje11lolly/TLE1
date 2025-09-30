class LogoAnimation {
    constructor() {
        this.logo = document.getElementById('animatedLogo');
        this.isAnimating = false;

        // Start the animation
        this.startAnimation();

        // Optional: Restart animation on click
        this.logo.addEventListener('click', () => {
            this.restartAnimation();
        });
    }

    startAnimation() {
        if (this.isAnimating) return;

        this.isAnimating = true;
        this.logo.classList.add('growing');

        // // Reset after animation completes
        // setTimeout(() => {
        //     this.resetLogo();
        // }, 2000);
    }

    resetLogo() {
        this.logo.classList.remove('growing');
        this.isAnimating = false;

        // Optional: Restart automatically after a delay
        setTimeout(() => {
            this.startAnimation();
        }, 1000);
    }

    restartAnimation() {
        this.resetLogo();
        setTimeout(() => {
            this.startAnimation();
        }, 50);
    }
}

// Initialize the animation when the page loads
document.addEventListener('DOMContentLoaded', () => {
    new LogoAnimation();
});