<template>
    <div class="w-50">

        <div class="clearfix" v-if="!storeEnabled">
            <span class="float-left cursor-pointer" v-html="actionMsg" v-on:click="actionMsg = ''"></span>
            <button type="button" class="btn btn-primary float-right" v-on:click="deleteEnabled = !deleteEnabled; storeEnabled = false">Edit list</button>
            <button type="button" class="btn btn-success float-right mr-2" v-on:click="storeEnabled = true; deleteEnabled = false">+ Add new</button>
        </div>
        <form @submit.prevent="storePerson" v-if="storeEnabled">
            <div class="clearfix mb-2">
                <span class="float-left cursor-pointer" v-html="storeMsg" v-on:click="storeMsg = ''"></span>
                <button type="button" class="ml-2 btn btn-secondary float-right" v-on:click="abortStore">Cancel</button>
                <button type="submit" class="btn btn-success float-right">Save</button>
            </div>
            <div class="form-row">
                <div class="col">
                    <input v-model="form.firstName" type="text" class="form-control" placeholder="First name">
                </div>
                <div class="col">
                    <input v-model="form.lastName" type="text" class="form-control" placeholder="Last name">
                </div>
                <div class="col">
                    <input v-model="form.phone" type="text" class="form-control" placeholder="Phone">
                </div>
                <div class="col">
                    <input v-model="form.email" type="text" class="form-control" placeholder="Email">
                </div>
                <div class="col">
                    <input v-model="form.city" type="text" class="form-control" placeholder="City">
                </div>
            </div>
        </form>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th v-on:click="filterBy('id')" v-bind:class="[filterSortBy === 'id' ? 'selected-column' : '']" class=" table-header " scope="col">#</th>
                    <th v-on:click="filterBy('first_name')" v-bind:class="[filterSortBy === 'first_name' ? 'selected-column' : '']" class=" table-header " scope="col">First name</th>
                    <th v-on:click="filterBy('last_name')" v-bind:class="[filterSortBy === 'last_name' ? 'selected-column' : '']" class="table-header" scope="col">Last name</th>
                    <th v-on:click="filterBy('phone')" v-bind:class="[filterSortBy === 'phone' ? 'selected-column' : '']" class="table-header" scope="col">Phone</th>
                    <th v-on:click="filterBy('email')" v-bind:class="[filterSortBy === 'email' ? 'selected-column' : '']" class="table-header" scope="col">Email</th>
                    <th v-on:click="filterBy('city')" v-bind:class="[filterSortBy === 'city' ? 'selected-column' : '']" class="table-header" scope="col">City</th>
                    <th v-if="deleteEnabled" class="table-header" scope="col" >Action</th>
                </tr>
                </thead>
            <tbody>
                <tr v-for="person in persons.data" :key="person.id">
                    <td>{{person.id}}</td>
                    <td>{{person.first_name}}</td>
                    <td>{{person.last_name}}</td>
                    <td>{{person.phone}}</td>
                    <td>{{person.email}}</td>
                    <td>{{person.city}}</td>
                    <td v-if="deleteEnabled"><button type="button" v-on:click="destroyPerson(person.id)" class="btn btn-danger">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item" v-on:click="paginateTo(link.url)"  v-bind:class="[link.active ? 'active' : '', link.url ? '' : 'disabled']" v-for="link in links">
                    <a class="page-link" v-on:click.prevent href="#"  v-html="link.label"></a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                storeEnabled: false,
                deleteEnabled: false,
                actionMsg: '',
                persons: '',
                storeMsg: '',
                filterSortBy:'first_name',
                filterDirection:false,
                links: '',
                indexLink: '/api/v1/person?sortby=first_name&direction=asc',
                form: new Form({
                    firstName: '',
                    lastName: '',
                    phone: '',
                    email: '',
                    city: ''
                })
            }
        },
        mounted(){
            this.index();
        },
        methods: {

            index(indexLinkParam = ''){
                //get the persons
                axios.get(this.indexLink).then((res) => {
                    this.persons = res.data;
                    this.links = res.data.meta.links;
                }).catch((error) => {
                    console.log(error)
                })
            },
            storePerson(){
                this.storeMsg = '';

                //get form data
                let data = new FormData();
                data.append('first_name', this.form.firstName);
                data.append('last_name', this.form.lastName);
                data.append('phone', this.form.phone);
                data.append('email', this.form.email);
                data.append('city', this.form.city);

                //save the new person
                axios.post('/api/v1/person', data).then((res) => {
                    this.form.reset();
                    this.index();
                    this.actionMsg = `The ${res.data.data.first_name} ${res.data.data.last_name} user saved.`;
                    this.storeEnabled = false;
                }).catch(error => {
                    let errors = error.response.data.errors;
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            this.storeMsg += `${errors[field]}<br/>`;
                        }
                    }
                });
            },
            updatePerson(){

            },
            destroyPerson(personId){
                //save the new person
                axios.delete(`/api/v1/person/${personId}`).then((res) => {
                    this.actionMsg = `The ${res.data.data.first_name} ${res.data.data.last_name} user saved.`;
                    this.index();
                }).catch(error => {
                    this.actionMsg = error.response.data.errors;
                });

                this.deleteEnabled = false;
            },
            abortStore(){
                this.storeEnabled = false;
                this.form.reset();
                this.storeMsg = '';
            },
            filterBy(filterColumn){
                this.filterSortBy = filterColumn;
                this.filterDirection = !this.filterDirection;
                this.indexLink = `/api/v1/person?sortby=${filterColumn}&&direction=${this.filterDirection ? 'desc' : 'asc'}`;

                    //re-fetch the person
                this.index();
            },
            paginateTo(link){
                this.indexLink = link;

                this.index();
            }

        }
    }
</script>

<style scoped>

</style>
