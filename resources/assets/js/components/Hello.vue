<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"> My love Gongyan</div>
                    <div class="panel-body">
                        {{ content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                content: "my love gongyan"
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>