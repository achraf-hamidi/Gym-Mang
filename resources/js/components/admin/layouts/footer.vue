<template>
   <div class="section-footer">
    <div class="clear-div">.</div>
      <footer class="footer footer-width">
        <div class="container-fluid clearfix text-center ">
            <span class="  text-muted d-block text-center d-sm-inline-block">Produit par <b> <a href="http://teknosolvo.com" target="_blank"  >TeknoSolvo</a> </b> </span>
        </div>
    </footer>
   </div>
</template>
<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}

</script>
<style>

.section-footer {
  display: flex;
justify-content: center;
align-items: center;
}

.clear-div {
  color : #0b0b0b ;
width : 270px ;
background : linear-gradient(to top, #0b0b0b, #0b0b0b) ;
padding: 20px 1rem;

}

.footer-width {
    transition: width 0.25s ease, margin 0.25s ease;
    width: calc(100% - 270px);
    float: right;
}

</style>
