<template>
    <div class="w-70">

        <div class="clearfix" v-if="!storeEnabled">
            <span class="float-left cursor-pointer" v-html="actionMsg" @click="actionMsg = ''"></span>
            <button type="button" class="btn btn-primary float-right" @click="deleteEnabled = !deleteEnabled; storeEnabled = false">Edit list</button>
            <button type="button" class="btn btn-success float-right mr-2" @click="storeEnabled = true; deleteEnabled = false">+ Add new</button>
        </div>
        <form @submit.prevent="storePerson" v-if="storeEnabled" >
            <div class="clearfix mb-2">
                <span class="float-left cursor-pointer" v-html="storeMsg" @click="storeMsg = ''"></span>
                <p class="float-left" v-if="form.errors.errors" >
                    <template v-for="(errorLabel, _ ) in form.errors.errors">
                        <span >{{errorLabel[0]}}</span><br/>
                    </template>
                </p>
                <button type="button" class="ml-2 btn btn-secondary float-right" @click="abortStore">Cancel</button>
                <button type="submit" class="btn btn-success float-right">Save</button>
            </div>
            <div class="form-row">
                <div class="col">
                    <input v-model="form.firstName" @keydown="form.errors.clear('first_name')" :class="[this.form.errors.has('first_name') ? 'is-invalid' : '']" type="text" class="form-control" placeholder="First name">
                </div>
                <div class="col">
                    <input v-model="form.lastName" @keydown="form.errors.clear('last_name')" :class="[this.form.errors.has('last_name') ? 'is-invalid' : '']" type="text" class="form-control" placeholder="Last name">
                </div>
                <div class="col">
                    <input v-model="form.phone" @keydown="form.errors.clear('phone')" :class="[this.form.errors.has('phone') ? 'is-invalid' : '']" type="text" class="form-control" placeholder="Phone">
                </div>
                <div class="col">
                    <input v-model="form.email" @keydown="form.errors.clear('email')" :class="[this.form.errors.has('email') ? 'is-invalid' : '']" type="text" class="form-control" placeholder="Email">
                </div>
                <div class="col">
                    <input v-model="form.city" @keydown="form.errors.clear('city')" :class="[this.form.errors.has('city') ? 'is-invalid' : '']" type="text" class="form-control" placeholder="City">
                </div>
            </div>
        </form>
        <table class="table table-striped mt-3 editable-table">
            <thead>
                <tr>
                    <th @click="filterBy('id')" :class="[filterSortBy === 'id' ? 'selected-column' : '']" class=" table-header " scope="col">#</th>
                    <th @click="filterBy('first_name')" :class="[filterSortBy === 'first_name' ? 'selected-column' : '']" class=" table-header " scope="col">First name</th>
                    <th @click="filterBy('last_name')" :class="[filterSortBy === 'last_name' ? 'selected-column' : '']" class="table-header" scope="col">Last name</th>
                    <th @click="filterBy('phone')" :class="[filterSortBy === 'phone' ? 'selected-column' : '']" class="table-header" scope="col">Phone</th>
                    <th @click="filterBy('email')" :class="[filterSortBy === 'email' ? 'selected-column' : '']" class="table-header" scope="col">Email</th>
                    <th @click="filterBy('city')" :class="[filterSortBy === 'city' ? 'selected-column' : '']" class="table-header" scope="col">City</th>
                    <th v-if="deleteEnabled" class="table-header" scope="col" >Action</th>
                </tr>
                </thead>
            <tbody >
                <tr v-for="person in persons.data" :key="person.id">
                    <td><p class="value-field no-margin">{{person.id}}</p></td>
                    <td><input class="value-field" :id="[`prs-inp-${person.id}-first_name`]" @focus="makeTdActive(person.id, 'first_name')" @blur="makeTdInactive(person.id, 'first_name')" v-model="person.first_name"> </td>
                    <td><input class="value-field" :id="[`prs-inp-${person.id}-last_name`]" @focus="makeTdActive(person.id, 'last_name')" @blur="makeTdInactive(person.id, 'last_name')" v-model="person.last_name"> </td>
                    <td><input class="value-field" :id="[`prs-inp-${person.id}-phone`]" @focus="makeTdActive(person.id, 'phone')" @blur="makeTdInactive(person.id, 'phone')" v-model="person.phone"> </td>
                    <td><input class="value-field" :id="[`prs-inp-${person.id}-email`]" @focus="makeTdActive(person.id, 'email')" @blur="makeTdInactive(person.id, 'email')" v-model="person.email"> </td>
                    <td><input class="value-field" :id="[`prs-inp-${person.id}-city`]" @focus="makeTdActive(person.id, 'city')" @blur="makeTdInactive(person.id, 'city')" v-model="person.city"> </td>
                    <td v-if="deleteEnabled"><button type="button" @click="destroyPerson(person.id)" class="btn btn-danger">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item" @click="paginateTo(link.url)"  v-bind:class="[link.active ? 'active' : '', link.url ? '' : 'disabled']" v-for="link in links">
                    <a class="page-link" @click.prevent href="#"  v-html="link.label"></a>
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
                indexLink: '/api/v1/person?fields=id,first_name,last_name,email,phone,city&sort_by=first_name&order_by=asc',
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
                    this.clearActionMsg();
                }).catch(error => {
                    let errors = error.response.data.errors;
                    this.form.errors.record(errors);
                });
            },
            clearActionMsg(){
                setTimeout(() => {
                    this.actionMsg = '';
                }, 3500);
            },
            updatePerson(){

            },
            destroyPerson(personId){
                //save the new person
                axios.delete(`/api/v1/person/${personId}`).then((res) => {
                    this.actionMsg = `The ${res.data.data.first_name} ${res.data.data.last_name} user deleted.`;
                    this.clearActionMsg();
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
                this.indexLink = `/api/v1/person?fields=id,first_name,last_name,email,phone,city&sort_by=${filterColumn}&&order_by=${this.filterDirection ? 'desc' : 'asc'}`;

                    //re-fetch the person
                this.index();
            },
            paginateTo(link){
                this.indexLink = link;

                this.index();
            },
            makeTdActive(personId, personField){
                let activeTd = document.querySelector(`#prs-inp-${personId}-${personField}`);

                if(activeTd.classList.contains('error'))
                {
                    this.index();
                    activeTd.classList.add('active');
                }
                else
                {
                    activeTd.classList.add('active');
                }

            },
            makeTdInactive(personId, personField){
                let activeTd = document.querySelector(`#prs-inp-${personId}-${personField}`);
                activeTd.classList.add('pending');
                activeTd.classList.remove('active');
                activeTd.classList.remove('error');

                let fieldUpdated = {};
                fieldUpdated[personField] = activeTd.value;

                //save the updates
                axios.patch(`/api/v1/person/${personId}`, fieldUpdated).then((res) => {
                    activeTd.classList.remove('pending');
                    this.index();
                }).catch(error => {
                    activeTd.classList.remove('pending');
                    activeTd.classList.add('error');
                });

            }

        }
    }
</script>

<style scoped>

</style>
