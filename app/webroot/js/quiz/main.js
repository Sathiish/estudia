 
function start(){
        $('#intro').hide();
        
        return false;
}

             function afficher(data) {
                  $("#quiz-vide").empty();
                  $("#quiz-vide").append(data);
                }

function next(i, nbreQuestion){

    
    if(i<nbreQuestion){
        
        var j = i + 1;
        
        $("#"+i).hide();
        $("#"+j).show();   

    }else{
        console.log('fini');
    }

    return false;
}
    
$(function(){    
    //$("#quiz div:not(#1)").hide();
//    $("#QuestionIndexForm").submit(function(){
//    inputName = "answerID"; console.log(inputName);
//    questionID = $(this).find("input[name="+inputName+"]").attr("id");  console.log(questionID);  
//    url = $(this).attr("action");
//    $.post(url,{questionId:questionID},function(data){
//            alert(url+' '+questionID);
//    }, "json") ;
//     return false;
//    });
}); 