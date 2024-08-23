<template>
   
    
     
                 <div class="card-body">
                    {{numberofpost.length === 0 ? 0 : numberofpost }}
                     <!-- {{ numberofpost }} -->
                 </div>
          
  </template>
  
  <script>
 //  import { toast } from 'vue3-toastify';
 //  import 'vue3-toastify/dist/index.css';
  
  
  
  export default {
      components: {
     
          },
          mounted() {
          
            //  console.log('Component mounted.')
      },
         // props:['order_id'],
          data() {
              return {
                  numberofpost:[],
                 //   showAlert: false,
                 //  orders: {},
                 //  display: false,
                
                
              }
          },
          created() {
            window.Echo.channel('PostNotification')
                  .listen('PostRecordNotification', (e) => {               
                      this.numberofpost = e.item;
              });
      },
     methods: {
        
        //  Getpost() {
          
        //  },
     }
     
    
      }
  </script> 
  