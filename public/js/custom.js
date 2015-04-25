function ajaxLogin(formMain, formButton, divMsg, formInput){
    formButton.click(function(){
        var bool = false;
        for(var i = 0; i < formInput.size(); i++){
            if(formInput.eq(i).val().length == 0 || formInput.eq(i).val().length < 5){
                bool = true;
            }
        }

        if(bool){
            divMsg.empty().append(' <i class="fa fa-warning" style="color: #E74C3C"></i> Input must have 5 or more characters');
        }else{
            $.ajax({
                type    : 'POST',
                url     : formMain.attr('action'),
                data    : formMain.serialize(),
                success : function(data){
                    if(data['bool']){
                        location.href = "/admin/home";
                    }else{
//                        divMsg.empty().append(' <i class="fa fa-warning" style="color: #E74C3C"></i> Invalid login credentials');
                        divMsg.empty().append(data['msg']);
                    }
                },error : function(){
                    divMsg.empty().append(' <i class="fa fa-warning" style="color: #E74C3C"></i> No network Connectivity');
                }
            })
        }
    })
}

function profileButtons(activateBtn, deactivateBtn, changepassBtn, id){
    activateBtn.click(function(){
        $('.confirm-acti-modal').attr('href', $(this).attr('data-href'));
//        var info = 'Confirm account deactivation for <font color="red">'+$('.first_'+$(this).attr('id')).text()+' '+$('.last_'+$(this).attr('id')).text()+'</font>';
        $('.modal-body-acti').empty().append('Confirm account activation for <font color="red">'+$(this).attr('data-name')+'</font>');
        $('#activateModal').modal().show();
    });

    deactivateBtn.click(function(){
        $('.confirm-deac-modal').attr('href', $(this).attr('data-href'));
//        var info = 'Confirm account deactivation for <font color="red">'+$('.first_'+$(this).attr('id')).text()+' '+$('.last_'+$(this).attr('id')).text()+'</font>';
        $('.modal-body-deac').empty().append('Confirm account deactivation for <font color="red">'+$(this).attr('data-name')+'</font>');
        $('#deactivateModal').modal().show();
    });

    changepassBtn.click(function(){
        $('.modal-header-changepass').empty().append('<i class="glyphicon glyphicon-asterisk" style="color: #F1C40F"></i> Change password for <font color="red">'+$(this).attr('data-name')+'</font>');
        $('#changepassModal').modal().show();
    });
}

function changepassValidation(pass1, pass2, passBtn, passMsg){
    pass1.change(function(){
        if(pass1.val().length < 5 || pass2.val().lenth < 5){
            passMsg.empty().append('<i class="fa fa-warning" style="color: red"></i> Password must be or more than 5 characters.');
        }else if(pass1.val() != pass2.val()){
            passMsg.empty().append('<i class="fa fa-warning" style="color: red"></i> Password did not match.');
        }
    });

    pass2.change(function(){
        if(pass1.val().length < 5 || pass2.val().lenth < 5){
            passMsg.empty().append('<i class="fa fa-warning" style="color: red"></i> Password must be or more than 5 characters.');
            passBtn.addClass('disabled');
        }else if(pass1.val() != pass2.val()){
            passMsg.empty().append('<i class="fa fa-warning" style="color: red"></i> Password did not match.');
            passBtn.addClass('disabled');
        }else{
            passMsg.empty();
            passBtn.removeClass('disabled');
        }
    })
}

function submitChangepass(form, btn, div){
    btn.click(function(){
        $.ajax({
            url     : form.attr('action'),
            type    : 'POST',
            data    : form.serialize(),
            success : function(data){
                if(data['bool']){
                    div.empty().append('<i class="fa fa-check" style="color: green"></i> Successfully changed password');
                }else{
                    div.empty().append(data['msg']);
                }
            },error : function(){
                div.empty().append('<i class="fa fa-warning" style="color : red"></i> No network connectivity.');
            }
        })
    });
}

function promotionsPage(){
    $('#imageUpload').change(function(){
        $('.files-names-div').hide();
        var inputFile = document.getElementById('imageUpload');
        for(var i = 0; i < inputFile.files.length; i++){
            $('.file-names').append('<br/>'+inputFile.files[i].name);
        }
        $('.files-names-div').show();
    });

    $('.cancel-modal').click(function(){
        $('.addLocationInput').val('');
    });

    $('.editInfo').click(function(){
        var id = $(this).attr('data-locid');
        $('#origName_'+id).hide();
        $('#origDesc_'+id).hide();
        $('#name_'+id).show();
        $('#desc_'+id).show();
        $('.btnSet1_'+id).hide();
        $('.btnSet2_'+id).show();
    });

    $('.cancelEdit').click(function(){
        var id = $(this).attr('data-locid');
        $('#origName_'+id).show();
        $('#origDesc_'+id).show();
        $('#name_'+id).hide();
        $('#desc_'+id).hide();
        $('.btnSet1_'+id).show();
        $('.btnSet2_'+id).hide();
    });

    $('.saveEdit').click(function(){
        var id = $(this).attr('data-locid'),
            form = $('#form_'+id),
            newName = $('#name_'+id).val(),
            newDesc = $('#textareaDesc_'+id).val();

        $.ajax({
            url     :   form.attr('action'),
            type    :   form.attr('method'),
            data    :   form.serialize(),
            success :   function(data){
                if(data['bool'] == 'FALSE'){
                    alert(data['msg']);
                }else{
                    alert(data['msg']);
                    $('#origName_'+id).empty().append(newName).show();
                    $('#origDesc_'+id).empty().append(newDesc).show();
                    $('#name_'+id).hide();
                    $('#desc_'+id).hide();
                    $('.btnSet1_'+id).show();
                    $('.btnSet2_'+id).hide();
                }
            },error :   function(){
                alert('Please check network connectivity');
            }
        })
    })
}