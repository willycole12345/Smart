<template>
                 <div class="card-body">
                    {{numberofcomment.length === 0 ? 0 : numberofcomment }}
                     <!-- {{ numberofcomment }} -->
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
                  numberofcomment:[],
                
                 //   showAlert: false,
                 //  orders: {},
                 //  display: false,
                
                
              }
          },
          created() {
            window.Echo.channel('CommentNotification')
                  .listen('CommentRecordNotification', (e) => {               
                      this.numberofcomment = e.item;
              });
      },
     methods: {
        //  Getcomment() {
            
        //  },
       
     }
     
    
      }
  </script> 
  