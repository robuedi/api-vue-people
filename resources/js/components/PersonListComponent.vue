<template>
    <div class="w-25">
        <form @submit.prevent="storePerson">
            <div class="input-group mb-3 w-100">
                <input v-model="form.firstName" type="text" class="form-control form-control-lg" aria-label="Person first name" aria-describedby="save-person"/>
                <input v-model="form.lastName" type="text" class="form-control form-control-lg" aria-label="Person last name" aria-describedby="save-person"/>
                <input v-model="form.phone" type="text" class="form-control form-control-lg" aria-label="Person phone" aria-describedby="save-person"/>
                <input v-model="form.email" type="text" class="form-control form-control-lg" aria-label="Person email" aria-describedby="save-person"/>
                <input v-model="form.city" type="text" class="form-control form-control-lg" aria-label="Person city" aria-describedby="save-person"/>
                <div class="input-group-append" >
                    <button class="btn btn-success" type="submit" id="save-person"></button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                persons: '',
                form: new Form({
                    firstName: '',
                    lastName: '',
                    phone: '',
                    email: '',
                    city: ''
                })
            }
        },
        methods: {
            index(){

            },
            storePerson(){

            },
            updatePerson(){

            },
            destroyPerson(){

            }
        }
    }
</script>

<style scoped>

</style>
