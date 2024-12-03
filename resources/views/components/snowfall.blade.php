<div x-data="snowfall()" class="fixed inset-0 overflow-hidden pointer-events-none" x-show="isChristmasSeason">
    <template x-for="snowflake in snowflakes" :key="snowflake.id">
        <div class="fixed text-white opacity-70"
            x-bind:style="{
                left: `${snowflake.x}vw`,
                top: '-10px',
                fontSize: `${snowflake.size}rem`,
                animation: `fall ${snowflake.speed}s linear infinite`,
                animationDelay: `-${snowflake.delay}s`,
                color: 'white'
            }"
            x-text="snowflake.design" />
    </template>
</div>

<style>
    @keyframes fall {
        0% {
            transform: translateY(-10vh) translateX(0) rotate(0deg);
        }

        100% {
            transform: translateY(110vh) translateX(20px) rotate(360deg);
        }
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('snowfall', () => ({
            snowflakes: [],
            snowflakeDesigns: ['❄', '❅', '❆'],
            isChristmasSeason: false,

            init() {
                const today = new Date();
                const start = new Date(today.getFullYear(), 10, 29);
                const end = new Date(today.getFullYear(), 11, 25);

                this.isChristmasSeason = today >= start && today <= end;

                if (this.isChristmasSeason) {
                    const snowflakeCount = 75;

                    for (let i = 0; i < snowflakeCount; i++) {
                        this.snowflakes.push({
                            id: i,
                            x: Math.random() * 100,
                            design: this.snowflakeDesigns[
                                Math.floor(Math.random() * this.snowflakeDesigns.length)
                            ],
                            size: Math.random() * (1.5 - 0.8) + 0.8,
                            speed: Math.random() * 15 + 10,
                            delay: Math.random() * 15
                        });
                    }
                }
            }
        }))
    })
</script>
