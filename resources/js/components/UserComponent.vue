
<template>
 <v-app id="inspire"> 
  <v-data-table
    item-key="name" 
  	class="elevation-1" 
  	color="error"
    :loading="loading"
  	loading-text="Loading... Please wait"
    :headers="headers"
    :items="users.data"
    :server-items-length="users.total"
    :items-per-page=5
    show-select
    @input="selectAll"
    @pagination="paginate"
    sort-by="calories"
    :footer-props="{
       itemsPerPageOptions: [5,10],
       itemsPerPageText: 'users per page',
       showCurrentPage: true,
       showFirstLastPage: true
  }"
  >
    <template v-slot:top>
    
      <v-toolbar flat color="dark">
        <v-toolbar-title>User  </v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-2" v-on="on">Add New User</v-btn>
            <v-btn color="primary" dark class="mb-2 mr-2" @click="deleteAll">Delete</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
         <v-form
             v-model="valid"
              method="post"
              v-on:submit.stop.prevent="save"
         >
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-text-field type="text" label="Name"  v-model="editedItem.name" :rules="[rules.required, rules.min]" ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field type="password" :rules="[rules.required]" v-model="editedItem.password" label="Type Password"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field type="password" :rules="[rules.required, passwordMatch]" v-model="editedItem.rpassword" label="Retype Password"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-text-field type="email" :rules="[rules.required, rules.validEmail]" v-model="editedItem.email" label="Type Email"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-select :items="roles" :rules="[rules.required]" v-model="editedItem.role" label="Select Role" ></v-select>
                  </v-col>
                  
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn type="submit" color="blue darken-1" text  @click.prevent="save">Save</v-btn>
            </v-card-actions>
         </v-form>   
          </v-card>
        </v-dialog>
      </v-toolbar>
       <v-row>
        <v-col cols="12">
          <v-text-field @input="searchIt" label="Search" class="mx-4" ></v-text-field>
        </v-col>
       </v-row>
    
    </template>
    <template v-slot:item.photo="{ item }" >
       <v-img :src="item.photo"  aspect-ratio="1" class="grey lighten-2" max-width="50" max-height="50"></v-img>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
     <v-snackbar v-model="snackbar">
      {{ text }}
      <v-btn color="pink"text @click="snackbar = false">
        Close
      </v-btn>
    </v-snackbar>
   </v-app> 
</template>

<script>
  export default {
    data: () => ({
      valid: true,
      loading: false,
      dialog: false,
      snackbar: false,
      text: '',
      selected: [],
      roles: [],
      rules: {
        required: v => !!v || 'This field is required',
        min: v => v.length >=5 || 'Minimum 5 Charecter Required',
        validEmail:  v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      },
      
      headers: [
        { text: '#', align: 'start',sortable: false,value: 'id'},
        { text: 'Name', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Role', value: 'role' },
        { text: 'Photo', value: 'photo' },
        { text: 'Created at', value: 'created_at' },
        { text: 'Updated at', value: 'updated_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      users: [],
      editedIndex: -1,
      editedItem: {
      	id:'',
        name: '',
        email: '',
        role: '',
        created_at: '',
        updated_at: ''
      
      },
      defaultItem: {
        id:'',
        name: '',
        email: '',
        role: '',
        photo: '',
        password: '',
        rpassword: '',
        created_at: '',
        updated_at: ''
        
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New User' : 'Edit User'
      },
      passwordMatch(){
        return this.editedItem.password != this.editedItem.rpassword ? 'Password Does not match' : ''
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      selectAll(e){
        this.selected = [];
        if(e.length > 0){
           this.selected = e.map(val => val.id)
        }
        // console.dir(this.selected)
      },
      deleteAll(){
        let decide =  confirm('Are you sure you want to delete these item?')
        if(decide){
           axios.post('/api/users/delete', {'user': this.selected})
            .then(res => {
              this.text = "Record Deleted Successfully";
              this.selected.map(val => {
                const index =  this.users.data.indexOf(val)
                this.users.data.splice(index, 1)
              })
              this.snackbar = true
            })
            .catch(err => { 
              console.log(err.response)
              this.text = "Error Deleting Record";
              this.snackbar = true
            })
         }
      },
      searchIt(e){
        // console.dir(e);
        if(e.length > 2 ){
          axios.get(`/api/users/${e}`)
            // .then(res => console.log(res.data.users))
            .then(res => this.users = res.data.users)
            .catch(err => console.dir(err.response))
        }
        // if(e.length<=0){
        //   axios.get(`/api/users`)
        //     .then(res => this.users = res.data.users)
        //     .catch(err => console.dir(err.response))
        // }
      },
      paginate(e){
        // console.dir(e)
         axios.get(`/api/users?page=${e.page}`,{params:{'per_page':e.itemsPerPage}})
        // .then(res => console.log(res.data.users) )
          .then(res => {
            // console.log(res.data.users)
            this.users = res.data.users 
            this.roles = res.data.roles 
          })

          .catch(err => {
            if(err.response.status == 401)
              localStorage.removeItem('token');
                this.$router.push('/login');
          })
      },
      initialize () {
        
        	// Add a request interceptor
			axios.interceptors.request.use((config) => {  // conver into ES6 format remove (function) add (=>) then we can this keyword also
			    // Do something before request is sent
			    this.loading = true;
			    return config;
			  }, (error) => {
			    // Do something with request error
			    this.loading = false;
			    return Promise.reject(error);
			  });

			// Add a response interceptor
			axios.interceptors.response.use((response) => {
			    // Any status code that lie within the range of 2xx cause this function to trigger
			    // Do something with response data
			    this.loading = false;
			    return response;
			  }, (error) => {
			    // Any status codes that falls outside the range of 2xx cause this function to trigger
			    // Do something with response error
			    this.loading = false;
			    return Promise.reject(error);
			  });
			
      },
     

      editItem (item) {
        this.editedIndex = this.users.data.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.users.data.indexOf(item)
        let decide =  confirm('Are you sure you want to delete this item?')
        if(decide){
        	 axios.delete('/api/users/'+item.id)
		        .then(res => {
              this.text = "Record Deleted Successfully";
		        	this.snackbar = true
		            this.users.data.splice(index, 1)
		        })
		        .catch(err => { 
              console.log(err.response)
              this.text = "Error Deleting Record";
              this.snackbar = true
            })
		     }
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
      	
        if (this.editedIndex > -1) {
         const index = this.editedIndex
         axios.put('/api/users/'+this.editedItem.id, {'name': this.editedItem.name})
	          .then(res => { 
              this.text = "Record Update Successfully";
              this.snackbar = true
              Object.assign(this.users.data[index], res.data.user)
            
            })
	          .catch(err => {
                console.log(err.response)
                this.text = "Error Updating Record"
                this.snackbar = true
           })
          // Object.assign(this.users[this.editedIndex], this.editedItem)
        } else {
        	axios.post('/api/users/', this.editedItem)
      	     
      	     .then(res => {
              this.text = "Record Added Successfully";
              this.snackbar=true;
              this.users.data.push(res.data.user)
           
            })
	      	 .catch(err => { 
              console.dir(err.response)
              this.text = "Error Inserting Record"
              this.snackbar = true
            })
	        }
	       this.close()
	      },
    },
}
  
</script>
<style scoped></style>