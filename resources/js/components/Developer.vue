<template>
    <div class="container">
        <div class="row" v-if="$gateAuth.isAdmin()">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">For Developer</h3>
                    </div>
                    <div class="card-body">
                        <passport-clients></passport-clients>
                        <passport-authorized-clients></passport-authorized-clients>
                        <passport-personal-access-tokens></passport-personal-access-tokens>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!$gateAuth.isAdmin()">
          <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default {
      
    }
</script>
