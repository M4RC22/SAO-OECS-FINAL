function initialize_local_data(){
    localStorage.clear();
    //Sidebar
    localStorage.setItem('_x_dropdown', false);
    //Forms  
    clear_form_local_storage('apf');
    clear_form_local_storage('brf');
    clear_form_local_storage('nr');
    clear_form_local_storage('lf');

}


//Clear data in local storage for passed form type 
function clear_form_local_storage(form, reload = false){

    let target_form = forms_array(form);
    let target_form_tables = form_tables_array(form);

    //Form Inputs
    target_form.forEach(element => {
        if(element === 'duration_unit'){
            localStorage.setItem(form+'_'+element, '"day(s)"');
        }else{
        localStorage.setItem(form+'_'+element, '')
        }
    });
     
     //Form Tables
     target_form_tables.forEach(element => {
        localStorage.setItem(form+'_'+element, JSON.stringify([]))
     });

     if(reload === true){
        setTimeout( () => {
            window.location.reload(true)
        },200)
        

     }
}


/********************************** 
 * 
 * Handles set and get of data to local storage
 * 
 * apf = Activity Proposal Form
 * 
 * brf = Budget Requisition Form
 * 
 * nr = Narrative Report
 * 
 * lf = Liquidation Form
 * 
**********************************/

//Push data to local storage if event occured in an element
function set_local_storage_data(form){
    return{

        storeInput($el) {
            let name = $el.name;
            let value = $el.value;

            localStorage.setItem(form+'_'+name, JSON.stringify(value));
        }
    }
}

//Assign value to input fields if data is available after onload of window
function get_local_storage_data(form){ 

    let current_form = forms_array(form) 
    
    current_form.forEach(element =>{
        document.getElementById(element).value = localStorage.getItem(form+'_'+element).slice(1, -1);  
    })
}

/*  

Accept a paramter that has possible value of 'apf', 'brf', 'nr', 'lf'.
Storage of arrays that contains id of input field for different forms.
Return an array based on the parameter passed.

*/
function forms_array(form){

    let apf_arr = [
        'target_date', 
        'duration_val',
        'duration_unit', 
        'venue', 
        'event_title', 
        'org_id',
        'organizer_organization_user_id', 
        'act_classification',
        'act_location', 
        'description', 
        'rationale', 
        'outcome',
        'primary_audience',
        'num_primary_audience',
        'secondary_audience',
        'num_secondary_audience',
    ]

    let brf_arr = [
        'event_id',
        'date_needed',
        'payment',
        'remarks',
        'department_id'
    ]

    let nr_arr = [
        'event_id',
        'venue',
        'narration',
    ]

    let lf_arr = [
        'event_id',
        'end_date',
        'cash_advance',
        'deduct',
    ]

    if(form === "apf"){
        return apf_arr;
    }else if (form === "brf"){
        return brf_arr;
    }else if(form === "nr"){
        return nr_arr;
    }else if (form === "lf"){
        return lf_arr;
    }
}

/*  

Accept a paramter that has possible value of 'apf', 'brf', 'nr', 'lf'.
Storage of arrays that contains id of tables's input field for different forms.
Return an array based on the parameter passed.

*/
function form_tables_array(form){

    let apf_tables = [
        'coorganizers',
        'logistics',
        'activities',
    ]; 

    let brf_tables = [
        'requisitions',
    ];

    let nr_tables = [
        'programs',
        'participants',
        'comments',
        'suggestions',
        'ratings',
    ];

    let lf_tables = [
        'liquidations',
        'proof_of_payments'
    ];

    if(form === "apf"){
        return apf_tables;
    }else if (form === "brf"){
        return brf_tables;
    }else if(form === "nr"){
        return nr_tables;
    }else if (form === "lf"){
        return lf_tables;
    }
}

