<style>
html,body {
    height: 100%;
}
body {
    background: #0f3854;
    background: radial-gradient(ellipse at center,  #0a2e38  0%, #000000 70%);
    background-size: 100%;
}
p {
    margin: 0;
    padding: 0;
}
#clock {
    font-family: 'Share Tech Mono', monospace;
    color: #ffffff;
    text-align: center;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: #daf6ff;
    text-shadow: 0 0 20px rgba(10, 175, 230, 1),  0 0 20px rgba(10, 175, 230, 0);

    .time {
        letter-spacing: 0.05em;
        font-size: 80px;
        padding: 5px 0;
    }
    .date {
        letter-spacing: 0.1em;
        font-size: 24px;
    }
    .text {
        letter-spacing: 0.1em;
        font-size: 12px;
        padding: 20px 0 0;
    }
}
#dynaclock {
    font-family: 'Share Tech Mono', monospace;
    color: #ffffff;
    text-align: center;
    position: absolute;
    left: 50%;
    top: 80%;
    transform: translate(-50%, -50%);
    color: #daf6ff;
    text-shadow: 0 0 20px rgba(10, 175, 230, 1),  0 0 20px rgba(10, 175, 230, 0);

    .time {
        letter-spacing: 0.05em;
        font-size: 80px;
        padding: 5px 0;
    }
    .date {
        letter-spacing: 0.1em;
        font-size: 24px;
    }
    .text {
        letter-spacing: 0.1em;
        font-size: 12px;
        padding: 20px 0 0;
    }
}
</style>
<template>
    <div id="clock">
        <p class="text">Your Current Timezone: {{ localtimezone }}</p>
        <p class="date">{{ localdate }}</p>
        <p class="time">{{ localtime }}</p>
    </div>

    <div>
        <select name="LeaveType" @change="timezoneFilter($event)" class="form-control" v-model="selectTimezone" >
            <option :value="zone" v-for="zone in timezone" :key="zone">{{ zone }}</option>
        </select>
    </div>

    <div id="dynaclock">
        <p class="text">Timezone: {{ dynatimezone }}</p>
        <p class="date">{{ dynadate }}</p>
        <p class="time">{{ dynatime }}</p>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        components: {
        },
        data() {
            return {
                localtime: '',
                localdate: '',
                localtimezone: '',
                dynatime: '',
                dynadate: '',
                dynatimezone: '',
                selectTimezone: '',
            }
        },
        props: {
            timezone: Array,
        },
        mounted() {
            const moment = require('moment-timezone');
            this.selectTimezone = this.$page.props.lasttimezone ? this.$page.props.lasttimezone.to : '';

            this.localtimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            var timerID = setInterval(this.localTime, 1000);
            var timerID = setInterval(this.getDateTime, 1000);

            this.localTime();

        },

        methods: {

            toTimeZone(time, zone) {
                var format = 'YYYY/MM/DD HH:mm:ss ZZ';
                return moment(time, format).tz(zone).format(format);
            },

            localTime() {
                this.localtime = this.zeroPadding(moment().tz(this.localtimezone).format('h'), 2) + ':' + this.zeroPadding(moment().tz(this.localtimezone).minute(), 2) + ':' + this.zeroPadding(moment().tz(this.localtimezone).second(), 2) + ' ' +moment().tz(this.localtimezone).format('A');
                this.localdate = this.zeroPadding(moment().tz(this.localtimezone).year(), 4) + '-' + this.zeroPadding(moment().tz(this.localtimezone).month()+1, 2) + '-' + this.zeroPadding(moment().tz(this.localtimezone).date(), 2) + ' ' + moment().tz(this.localtimezone).format('MMMM');
            },

            zeroPadding(num, digit) {
                var zero = '';
                for(var i = 0; i < digit; i++) {
                    zero += '0';
                }
                return (zero + num).slice(-digit);
            },

            timezoneFilter(event) {
                this.selectTimezone = event.target.value;
                const formData = new FormData();
                formData.append('count', 1);
                formData.append('fromZone', this.$page.props.lasttimezone ? this.$page.props.lasttimezone.to : '');
                formData.append('toZone', this.selectTimezone);
                axios.post(this.route('updateTimeZone'), Object.assign(formData)).then((data) => {
                    console.log(data);
                });
                this.getDateTime();
            },

            getDateTime() {
                if(this.selectTimezone) {
                    this.dynatime = this.zeroPadding(moment().tz(this.selectTimezone).format('h'), 2) + ':' + this.zeroPadding(moment().tz(this.selectTimezone).minute(), 2) + ':' + this.zeroPadding(moment().tz(this.selectTimezone).second(), 2) + ' ' +moment().tz(this.selectTimezone).format('A');
                    this.dynadate = this.zeroPadding(moment().tz(this.selectTimezone).year(), 4) + '-' + this.zeroPadding(moment().tz(this.selectTimezone).month()+1, 2) + '-' + this.zeroPadding(moment().tz(this.selectTimezone).date(), 2) + ' ' + moment().tz(this.selectTimezone).format('MMMM');
                    this.dynatimezone = this.selectTimezone;
                }
            }



        }

}
</script>
