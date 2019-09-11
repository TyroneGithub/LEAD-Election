function addStudent(){
    document.getElementById("form-hide").style.display="block";
    document.getElementById("table-hide").style.display="none";
    document.getElementById("header-admin").style.zIndex="-1";
    overlay_on();   
}
function addStudent_off(){
    document.getElementById("form-hide").style.display="none";
    document.getElementById("table-hide").style.display="block";
    document.getElementById("header-admin").style.zIndex="60";
    overlay_off();

}
function overlay_on(){
    document.getElementById("overlay").style.display="block";
    
}
function overlay_off(){
    document.getElementById("overlay").style.display="none";

}
function edit_box(){
    document.getElementById("edit-box").style.display="block";
}
function addCandidate(){
    document.getElementById("candidate-form").style.display="block";
    document.getElementById("candidate-table").style.display="none";
    document.getElementById("header-admin").style.zIndex="-1";
    overlay_on();   
}
function addCandidate_off(){
    document.getElementById("candidate-form").style.display="none";
    document.getElementById("candidate-table").style.display="block";
    document.getElementById("header-admin").style.zIndex="60";
    overlay_off();

}
function importcsv_on(){
    document.getElementById("csv-form").style.display="block";
    document.getElementById("table-hide").style.display="none";
    document.getElementById("header-admin").style.zIndex="-1";
    overlay_on();   
}

function importcsv_off(){
    document.getElementById("csv-form").style.display="none";
    document.getElementById("table-hide").style.display="block";
    document.getElementById("header-admin").style.zIndex="60";
    overlay_off();
}