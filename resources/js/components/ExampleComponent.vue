<template>



    <div class="card-body">
        <!-- {{ numberofUserCreated }} -->
        {{numberofUserCreated.length === 0? 0 : numberofUserCreated }}
        <!-- {{ numberofUserCreated }} -->
    </div>

</template>

<script>
//  import { toast } from 'vue3-toastify';
//  import 'vue3-toastify/dist/index.css';



export default {
    components: {
        alert
    },
    mounted() {
       
    },
    // props:['order_id'],
    data() {
        return {

            numberofUserCreated: [],

            //   showAlert: false,
            //  orders: {},
            //  display: false,


        }
    },
    created() {
        window.Echo.channel('notification')
                .listen('RecordUpdateNotification', (e) => {
                    this.numberofUserCreated = e.item;
                });
    },
    methods: {
        // Getuser() {
        //     window.Echo.channel('notification')
        //         .listen('RecordUpdateNotification', (e) => {
        //             this.numberofUserCreated = e.item;
        //         });
        // },
    }


}
</script>