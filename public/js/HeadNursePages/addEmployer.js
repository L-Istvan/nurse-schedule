function confirmDelete() {
    if (confirm("Biztosan törölni szeretné a felhasználót   ?")) {
        console.log("sikeres törlés");
    }
    else {
      event.preventDefault();
      console.log("nem");
      return false;
    }
  }
function save(){
    toastr.options = {"positionClass": "toast-top-center"};
    inputName = document.getElementById('inputName').value;
    inputEmail = document.getElementById('inputEmail').value;
    selectedEducation = document.getElementById('selectedEducation').value;
    inputRank = document.getElementById('inputRank').value;
    array = {"inputName" : inputName,"inputEmail": inputEmail,
    "selectedEducation":selectedEducation,"inputRank": inputRank};
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/sendInputEmployee',
        data : JSON.stringify(array),
        contentType: 'application/json',
        complete: function(xhr){
            if (xhr.status == 200) toastr.success(xhr.responseJSON['message']);
            else toastr.error(xhr.responseJSON['message']);
        }
    });
}
