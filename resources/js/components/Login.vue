<template>
    <section class="login">

        <form action="/rps/login"  method="post">

            <h1>{{fullname}}</h1>
            <h2>Sign in </h2>
            <input type="text" v-model="fullname" class="uname" placeholder="Enter your name"/>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </section>
</template>

<!--<script>-->
<!--  export default {-->
<!--    name: "Login.vue",-->

<!--    data () {-->
<!--      return {-->
<!--        fullname :'',-->
<!--        response : []-->
<!--      }-->
<!--    },-->
<!--    created() {-->
<!--      console.log(this.fullname)-->
<!--    },-->

<!--    methods : {-->
<!--      submitLogin() {-->
<!--        console.log('submitted, ', this.fullname)-->

<!--        axios.post('/rps/login', this.fullname)-->
<!--            .then((resp)=>{console.log('resp=', resp); this.response = resp-->
<!--              window.location.href = resp.request.responseURL;-->
<!--            })-->
<!--            .catch(error=>{console.log('error=>',error.message)})-->


<!--      }-->
<!--    }-->
<!--  }-->
<!--</script>-->

<style scoped>

</style>
