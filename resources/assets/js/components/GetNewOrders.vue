<template>
<div>
       <div class="col-lg-8 m-auto" v-for="order in neworders">
          <form>
             <div class="dash-new-order my-3">
                <div class="new-order-info">
                   <p class="black"><span class="bolded-font">Date: </span> {{order.created_at}}</p>
                   <p class="black"><span class="bolded-font">Order Id: </span>10</p>
                   <p class="black"><span class="bolded-font">Time:  </span> 11:00 PM</p>
                </div>
                <div class="shipping-goods p-5">
                   <div class="goods-all py-3">
                      <div class="goods-content my-3">
                         <div class="good-image">
                            <img class="img-fluid" src="imgs/cart1.jpg"/>
                            <div class="item-numb">3</div>
                         </div>
                         <p>OPEN FRONT KNIT BLAZER . MID GREY MELANGE</p>
                         <p class="black bolded-font">1500LE</p>
                      </div>
                      <div class="goods-content">
                         <div class="good-image">
                            <img class="img-fluid" src="imgs/cart3.jpg"/>
                            <div class="item-numb">10</div>
                         </div>
                         <p>OPEN FRONT KNIT BLAZER . MID GREY MELANGE</p>
                         <p class="black bolded-font">1500LE</p>
                      </div>
                   </div>
                   <div class="goods-all py-3">
                      <div class="order-prices">
                         <p>Total</p>
                         <h5 class="black bolded-font">588885LE</h5>
                      </div>
                   </div>
                   <div class="client-info my-4">
                      <p class="black" ><span class="bolded-font">Client Name: </span> Ahmed Ahmed</p>
                      <p class="black" ><span class="bolded-font">Client Address: </span> Lorem Ipsum is simply dummy text of the pr</p>
                      <p class="black" ><span class="bolded-font">Mobile: </span> 0100000000000</p>
                   </div>
                </div>
             </div>
          </form>
       </div>
</div>
</template>

<script>


    export default {
        data: function () {
            return {
                neworders: []
            }
        },
        created() {
            this.getNewOrders()
        },
        methods: {
            getNewOrders() {
                var app = this;
                axios.get('api/getorders')
                    .then(function (resp) {
                        app.neworders = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not load Orders");
                    });

            }
        }
    }
</script>