<template>
  <div>    
    <section class="content-header">
      <h1>
       Bus Management
        <!-- <small>Optional description</small> -->
      </h1>
      <ol class="breadcrumb">        
        <li>
          <router-link to="/dashboard" exact>
            <i class="fa fa-dashboard"></i>Dashboard
          </router-link>
        </li> 
        <li class="active">Admin Staff</li>
      </ol>
    </section>

    <section class="content">      
      <div class="row">
          
          <!-- <div class="col-md-8 col-md-offset-1"> -->
          <!-- <div class="col-md-8 col-md-offset-1"> -->
            <div class="panel panel-default">
              <div class="panel-heading">Add New Bus</div>
              <div class="panel-body">
                <form> 
                 <div class="form-group">
                    <label for="busId"> Bus Ids </label>
                    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                    <select v-model="selectedBusId" class="form-control" id="busId">
                      <option disabled value="">Please select one</option>
                      <option v-for="busId in busIds">
                        {{ busId }}
                      </option>                           
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="numberOfCol">Number of Column</label>
                    <input v-model="numberOfCol" type="number" min="1" max="4" value="4" class="form-control" id="numberOfCol" placeholder="Column Number" disabled>
                  </div>

                  <div class="form-group">
                    <label for="numberOfRow">Number of Row</label>
                    <input v-model="numberOfRow" type="number" min="1" max="25" value="9" class="form-control" id="numberOfRow" placeholder="Row Number" :disabled="isDisabled">
                  </div>
                  <button v-on:click.prevent="createList()" class="btn btn-primary" :disabled="disableShowButton">Show</button>
                  <button v-on:click.prevent="reset()" class="btn btn-primary">Reset</button>
                  <button v-on:click.prevent="saveSeatList()" class="btn btn-primary" :disabled="disableSaveButton">Save</button>
                </form>  
              </div>
            </div>
          <!-- </div> -->

      </div>
      <loader :show="loading">
               <!--  {{-- <div class="loading"><i v-show="loading" class="fa fa-spinner fa-pulse fa-3x text-primary"></i></div> --}} -->
    </loader>

      <div class="row">
            <div class="panel panel-default">
              <div class="panel-heading">Seat Planning</div>
              <div class="panel-body">
              
              <div class="seat-layout">
                <button
                    class="col-xs-2"            
                    v-bind:class="{ active : seat.checked, 
                            inactive : !seat.checked, 
                            'col-xs-offset-2': emptySpace(index, seat.no)
                            }"
                    v-for="(seat, index) in seatList"          
                    @click="toggle(seat)"                               
                >                       
                    <i class="fa fa-check fa-lg tickmark" v-show="seat.checked"></i>
                    <i class="fa fa-times fa-lg crossmark" aria-hidden="true" v-show="!seat.checked"></i>

                    <!-- {{ seat.no }} - {{ seat.sts }} : {{index}}  -->
                    {{ seat.no }} - {{ seat.sts }} : {{index}} 
                    
                </button> 
              </div>
                 
              </div>
            </div>  
          
        </div>        
    </section>        
  </div>      
</template>
<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
        data() {
                return {
                    busIds: [],
                    disableShowButton: false,
                    disableSaveButton: true,
                    error: '',
                    numberOfCol: 4,                            
                    numberOfRow: 4,                            
                    response: '',
                    seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],
                    seatList: [],
                    selectedBusId: '',
                    seatListLength: '',
                    //seatList2: [],
                    //finalSeatList: [],
                    //seatStatus: '',
                    isDisabled: false,
                    index: 2, // empty space strating for this index then index+4
                    indexList: [],
                    loading: false,
                   // lastRowSeatList:[]                            
                }

                },
                mounted() {
                    this.fetchBusIds();
                    this.createIndexList();                  
                },
                watch: {
                    
                    numberOfRow() {
                        this.createIndexList();
                        this.isShowButtonDisable();                        
                    },

                    selectedBusId() {
                        this.isSaveButtonDisable();
                    },
                    seatListLength() {
                        this.isSaveButtonDisable();
                    },


                },      
                methods: {
                    createIndexList() {
                        this.indexList=[];
                        var r;
                        var numberOfRow = this.numberOfRow;
                        var index = this.index;
                        for ( r=1; r<numberOfRow; r++ ) { 
                            this.indexList.push(index);
                            index = index+4; 
                            //console.log('index', index);
                        }
                    },

                    isShowButtonDisable() {
                        this.disableShowButton = ( this.numberOfRow == '' || this.numberOfRow == 0) ? 
                                                true : false;
                    },

                     isSaveButtonDisable() { 
                        
                        this.disableSaveButton = ( this.selectedBusId == '' || this.seatListLength == '') ? 
                                                true : false;
                      /* if ( this.selectedBusId == '' || this.seatListLength == '') {
                       
                            console.log( 'DISABLE SAVE BUTTION = TRUE');
                            this.disableSaveButton = true;
                            return;
                        }
                         console.log( 'DISABLE SAVE BUTTION = FALSE');
                         this.disableSaveButton = false;
                         return;*/

                    },

                    /*emptySpace(seatNo) {

                        if ( this.isFiveCol(seatNo) ) {
                            return false; // no need empty space between columns
                        }
                        var seatNumber = parseInt(seatNo.match(/\d+/),10);                      
                        return ( (seatNumber % 3) == 0 ) ? true : false;

                    }, */                 

                    emptySpace(index, seatNo) {  //2, 6, 10

                        if ( this.isFiveCol(seatNo) ) {
                            return false; // no need empty space between columns
                        }
                        return this.isEmptySpaceAvailable(index);
                    }, 

                    isEmptySpaceAvailable(index) {

                        var val = this.indexList.find( function(indx) {                            
                            return indx == index;
                        });
                        return (index == val) ? true : false;
                    },
                    
                    isFiveCol(seatNo) {
                        
                        // var seatListLength =  this.seatList.length;
                        // var numberOfRow = (seatListLength-1) /4; //2
                        var numberOfRow = this.numberOfRow;
                        var lastRowChar = this.seatChar[numberOfRow-1]; //B
                        lastRowChar = lastRowChar.trim();
                        
                        var seatChar = seatNo.substr(0, 1); //extract char from seat no
                        return ( lastRowChar == seatChar ) ? true : false ;
                    },
                    
                    fetchBusIds() {
                        //this.error = false;
                        this.loading = true;
                        //this.cityToList = [];
                        var vm = this;
                        axios.get('/bus/ids')          
                            .then(function (response) {
                              //vm.answer = _.capitalize(response.data.answer)
                              // console.log(response.data);
                               response.data.error ? vm.error = response.data.error : vm.busIds = response.data;
                               vm.loading = false;
                              // console.log(vm.error);
                               //vm.cityToList = response.data;
                               //vm.message= response.data
                        });
                    },

                    createList() {
                        var r; //row                    
                        var code = 64;
                        var seatNo;
                        var numberOfRow = this.numberOfRow//8;
                        var numberOfCol = this.numberOfCol //4;
                        for ( r=1; r<=numberOfRow; r++ ) {
                            // console.log('row=', r);
                            var c; //col                            
                            for( c=1; c<=numberOfCol; c++) {
                                seatNo = String.fromCharCode(code+r)+ c ;
                                // console.log('col=', c);
                                // console.log('seat=', seatNo); 
                                this.seatList.push({
                                    no: seatNo,
                                    sts: 'available', 
                                    checked: true
                                });
                            }
                        }
                        seatNo = String.fromCharCode(code+numberOfRow)+ c ; //64+6 + 5 E5
                        this.seatList.push({
                                    no: seatNo,
                                    sts: 'available', 
                                    checked: true
                        }); 

                        //this.finalSeatList = this.seatList.concat();
                        this.isDisabled = true;
                        this.disableShowButton = true;
                        this.seatListLength = this.seatList.length;
                        
                    },
                    
                    reset() {
                        this.seatList=[];
                        //this.numberOfRow = '';
                        this.isDisabled = false;
                        this.disableShowButton = false;
                        this.seatListLength= '';
                    },

                    saveSeatList() {
                        var vm = this;
                        this.loading = true;
                        axios.post('/bus/seatplan', {
                            bus_id: this.selectedBusId,
                            seat_list: this.seatList
                        })          
                        .then(function (response) {
                               console.log(response.data);
                                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                               vm.loading = false;
                        });
                    },

                    updateSeatList(seat) {
                        // if (seat.sts == 'n/a') {
                            var index = this.seatList.indexOf(seat);
                            this.seatList[index+1].no = seat.no;
                        //}
                    },                    
                    toggle(seat) {
                       // var index = this.seatList.indexOf(seat);
                        // console.log('indexxxxx',index);                     
                        // console.log(this.seatList[index]);                     
                        seat.checked = !seat.checked;                                   
                        if (seat.checked) {
                            seat.sts = 'available';
                            //this.seatStatus= '';                            
                            return ;
                        }                                                       
                        seat.sts = 'n/a';
                       // this.seatStatus= 'n/a';
                       //this.seatList2 = this.seatList.concat();
                        //this.seatList[index+1].no = seat.no;
                       this.updateSeatList(seat);                       
                    }
                }
    }
</script>
<style>
    .active {
        background-color: #f4e542;
        position: relative;
    }                   
    .inactive {
        background-color: #c4c0c0;  
    }                       
    .tickmark {
        /*background-color: green;*/
        color: green;
        /*padding: 5px;*/
    }
    .crossmark {
        /*background-color: red;*/
        /*padding: 5px;*/
        color: red;
    }
    #app button {               
        height: 50px;
        margin: 10px 10px 0 0;
    }
    #app button.col-xs-2 {
        width: 16.76666667%;
    }
    #app button.col-xs-offset-2 {
        margin-left: 17.666667%;
    }

    .content { 
        padding-left: 30px;
        padding-right: 30px;
    }

    #app .seat-layout {
        padding-left: 50px;
    }
</style>