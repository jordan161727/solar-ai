window.counter = (target) => ({
    count: 0,

    target: target,

    start() {

        let step = Math.ceil(this.target / 80);

        let timer = setInterval(() => {

            this.count += step;

            if (this.count >= this.target) {

                this.count = this.target;

                clearInterval(timer);

            }

        },20);

    }
});

window.liveClock = () => ({

    time:'',

    init(){

        this.update();

        setInterval(()=>{

            this.update();

        },1000)

    },

    update(){

        this.time=new Date().toLocaleTimeString();

    }

})