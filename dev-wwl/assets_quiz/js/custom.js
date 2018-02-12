
$(".form-horizontal").delegate("#rightAnswer", "change", function() {
    $(this).parents(".choices").find("[type='checkbox']").not(this).prop('checked', false);
});
// Prevent USer submitting the form with enter key
$(document).ready(function() {
    $(window).keydown(function (event) {
        if ((event.keyCode === 13)) {
            event.preventDefault();
            return false;
        }
    });
});
// Adding new Choice in the Choices section
$(".form-horizontal").delegate("#add_choice", "click", function (ac) {
    ac.preventDefault();
    var count = $(this).parents(".question").children(".choices").find("#choice_count").val();

    count = parseInt(count) + 1;
    $(this).parents(".question").children(".choices").find("#choice_count").val(count);
    $(this).parents(".question").children(".choices").append('                            <div class="choice">\n' +
        '                                <div class="form-group">\n' +
        '                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>\n' +
        '                                    <div class="col-sm-4">\n' +
        '                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">\n' +
        '                                    </div>\n' +
        '                                    <div class="col-sm-2 custom-tick">\n' +
        '                                        <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on"> Right Answer\n' +
        '                                    </div>\n' +
        '                                    <div class="col-sm-2">\n' +
        '                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </div>\n');
});

// Delete Choice
$(".form-horizontal").delegate("#delete_choice", "click", function (dc) {
    dc.preventDefault();
    var count = $(this).parents(".choices").find("#choice_count").val();
    if (count > 2) {
        count = parseInt(count) - 1;
        $(this).parents(".choices").find("#choice_count").val(count);
        $(this).parents('.choice').remove();
    }
});

// Adding new Question in  the Survey Page
$(".form-horizontal").delegate("#add_question", "click", function (aq) {
    aq.preventDefault();
    var qcount = $(this).parents("#quiz_form").children(".questions-list").find("#question_count").val();
    qcount = parseInt(qcount) + 1;
    $(this).parents("#quiz_form").children(".questions-list").find("#question_count").val(qcount);
    $(".questions-list").append('                    <div class="question">\n' +
        '                        <div class="col-md-4 col-xs-12">\n' +
        '                            <h4 class="add-quiz-title">Question</h4>\n' +
        '                        </div>\n' +
        '                        <div class="col-md-8 col-xs-12">\n' +
        '                            <div class="list-options pull-right">\n' +
        '                                <button class="option" id="question_up"><i class="glyphicon glyphicon-arrow-up"></i> Move Up</button>\n' +
        '                                <button class="option" id="question_down"><i class="glyphicon glyphicon-arrow-down"></i> Move Down</button>\n' +
        '                                <button class="option" id="delete_question"><i class="glyphicon glyphicon-trash"></i> Delete Question</button>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <div class="form-group">\n' +
        '                            <label for="question_type" class="col-sm-2 control-label">Question Type : </label>\n' +
        '                            <div class="col-sm-4">\n' +
        '                                <select name="question_type[]" id="question_type" class="form-control">\n' +
        '                                    <option value="many">Select Many</option>\n' +
        '                                    <option value="one">Enter One</option>\n' +
        '                                </select>\n' +
        '                            </div>\n' +
        '                            <div class="col-md-3">\n' +
        '                                <input type="checkbox" name="Isrequired[]" value="on" id="Isrequired" > Required Question\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <div class="form-group">\n' +
        '                            <label for="question_text" class="col-sm-2 control-label">Question Text : </label>\n' +
        '                            <div class="col-sm-9">\n' +
        '                                <input type="text" class="form-control" id="question_text" name="question_text[]" placeholder="Enter Question Text" required="required">\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <div class="form-group">\n' +
        '                            <label for="question_text" class="col-sm-2 control-label">Question Image : </label>\n' +
        '                            <div class="col-sm-9">\n' +
        '                                <input type="file" class="form-control" id="question_image" name="question_image[]">\n' +
        '                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <div class="choices">\n' +
        '                            <div class="col-md-10 col-xs-12 col-md-offset-2">\n' +
        '                                <h4>Choices</h4>\n' +
        '                            </div>\n' +
        '                            <div class="choice">\n' +
        '                                <div class="form-group">\n' +
        '                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>\n' +
        '                                    <div class="col-sm-4">\n' +
        '                                        <input type="text" class="form-control" id="choice" name="choice[]"  placeholder="Enter Answer" required="required">\n' +
        '                                    </div>\n' +
        '                                    <div class="col-sm-2 custom-tick">\n' +
        '                                        <input type="checkbox" id="rightAnswer"  name="rightAnswer[]" value="on"> Right Answer\n' +
        '                                    </div>\n' +
        '                                    <div class="col-sm-2">\n' +
        '                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="choice">\n' +
        '                                <div class="form-group">\n' +
        '                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>\n' +
        '                                    <div class="col-sm-4">\n' +
        '                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">\n' +
        '                                    </div>\n' +
        '                                    <div class="col-sm-2 custom-tick">\n' +
        '                                        <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on"> Right Answer\n' +
        '                                    </div>\n' +
        '                                    <div class="col-sm-2">\n' +
        '                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <input type="hidden" value="2" name="choice_count[]" id="choice_count">\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-10 col-md-offset-2">\n' +
        '                            <button class="option" id="add_choice"><i class="glyphicon glyphicon-plus"></i> Add Choice</button>\n' +
        '                        </div>\n' +
        '                    </div>\n');
});

// Delete Question
$(".form-horizontal").delegate("#delete_question", "click", function (dq) {
    dq.preventDefault();
    var qcount = $(this).parents("#quiz_form").children(".questions-list").find("#question_count").val();
    if (qcount > 1) {
        qcount = parseInt(qcount) - 1;
        $(this).parents("#quiz_form").children(".questions-list").find("#question_count").val(qcount);
        $(this).parents('.question').remove();
    }
});


// Change Order
$(".form-horizontal").delegate("#question_up", "click", function (qu) {
    qu.preventDefault();
    $(this).parents('.question').insertBefore($(this).parents('.question').prev());
});
$(".form-horizontal").delegate("#question_down", "click", function (qd) {
    qd.preventDefault();
    $(this).parents('.question').insertAfter($(this).parents('.question').next());
});

// Change Question Type
$('.form-horizontal').delegate("#question_type", "change", function () {
    $(this).parents(".question").children(".choices").find("#choice_count").val(1);
    if(this.value === "one") {
        $(this).parents(".question").find("#add_choice").remove();
        $(this).parents(".question").children(".choices").empty().append('<div class="choice">\n' +
            '                                <div class="form-group">\n' +
            '                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>\n' +
            '                                    <div class="col-sm-4">\n' +
            '                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">\n' +
            '                                    </div>\n' +
            '                                    <div class="col-sm-2 custom-tick">\n' +
            '                                        <input type="checkbox" id="rightAnswer" name="rightAnswer[]" checked value="on" disabled> Right Answer\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>' +
            '<input type="hidden" value="1" name="choice_count[]" id="choice_count">');
    } else if (this.value === "many"){
        $(this).parents(".question").children(".col-sm-10.col-md-offset-2").append('                            <button class="option" id="add_choice"><i class="glyphicon glyphicon-plus"></i> Add Choice</button>\n');
        $(this).parents(".question").children(".choices").children(".choice").empty().append('<div class="choice">\n' +
            '    <div class="form-group">\n' +
            '        <label for="choice" class="col-sm-2 control-label">Choice: </label>\n' +
            '        <div class="col-sm-4">\n' +
            '            <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">\n' +
            '        </div>\n' +
            '        <div class="col-sm-2 custom-tick">\n' +
            '            <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on"> Right Answer\n' +
            '        </div>\n' +
            '        <div class="col-sm-2">\n' +
            '            <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>\n' +
            '<div class="choice">\n' +
            '    <div class="form-group">\n' +
            '        <label for="choice" class="col-sm-2 control-label">Choice: </label>\n' +
            '        <div class="col-sm-4">\n' +
            '            <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">\n' +
            '        </div>\n' +
            '        <div class="col-sm-2 custom-tick">\n' +
            '            <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on"> Right Answer\n' +
            '        </div>\n' +
            '        <div class="col-sm-2">\n' +
            '            <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>\n' +
            '<input type="hidden" value="2" name="choice_count[]" id="choice_count">\n');
    }
});


// Form Submission Ajax
$('#quiz_form').delegate("#save-quiz", "click", function (events) {


    events.preventDefault();
    var rightAnswer = [];
    var Isrequired = [];
    var form = $('#quiz_form')[0];
    var info = new FormData(form);
    var error = 0;
    $('.question').each(function (data) {
        var pass = 0;
        if($(this).find("input#rightAnswer").is(":checked")){
            pass++;
        }
        if (pass === 0) {
            $(this).find(".choices").prepend('<div class="col-sm-10 col-sm-offset-1 alert alert-danger">Please Choose 1 right answer</div>');
            error++
        }
    });
    
    $('#quiz_form :input').each(function(index){
        
        //alert($(this).attr('name') );
        if ($(this).attr('type') === 'checkbox'){
            if ($(this).attr('name') === 'rightAnswer[]'){
                if ($(this).is(':checked')){
                    rightAnswer.push(1);
                    info.append('rightAnswers[]', 1);
                } else {
                    info.append('rightAnswers[]', 0);
                }
            } else if ($(this).attr('name') === 'Isrequired[]'){
                if ($(this).is(':checked')){
                    info.append('requiredQuestion[]', 1);
                } else {
                    info.append('requiredQuestion[]', 0);
                }
            } else if ($(this).attr('name') === 'isRandomized') {
                if ($(this).is(':checked')) {
                    info.append('Randomized', 1);
                } else {
                    info.append('Randomized', 0);
                }
            }
        } else if ($(this).attr('type') === 'text') {
            if ($(this).attr('required', true)) {
                if ($(this).val() === "") {
                    $(this).parents(".form-group").addClass("has-error");
                    //alert($(this).attr('name') );
                    error++;
                }
            }
        } else if ($(this).attr('type') === "file"){
            if ($(this)[0].files[0] === undefined) {
                info.append('has_image[]', 0);
            } else {
                info.append('has_image[]',1);
            }
        }
    });
    //alert("error" + error);
    if (error === 0) {
        var gameid=document.getElementById("game_id").value;
         var quizid=document.getElementById("quiz_id").value;
         //alert(quizid);
        info.append('gameid',gameid);
        info.append('quizid',quizid);

        $.ajax({
            url: 'Models/Create_Quiz.php',
            type: 'POST',
            data: info,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(dataa) {
                //alert(dataa);
                alert("Quiz Created Successfully");
                document.location="game-draft-publish.php";
                //$('#quiz_form').empty().append('<div class="alert alert-success"><p>Quiz Created Successfully</p><p>You Can access the Quiz From </p><a href="index.php?id='+dataa.Quiz_id+'">Here</a> </div>')
            }
        });
    }
});


// Submit Answer
$("#question_form").delegate("#finish", "click", function (event) {
        var $validator = $('.wizard-card form').validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 3
                },
                lastname: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    minlength: 3,
                }
            },

            errorPlacement: function(error, element) {
                $(element).parent('div').addClass('has-error');
            }
        });
        var $valid = $('.wizard-card form').valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
        } else {
            event.preventDefault();
        }
   var timecount= $('.wrapper .count').text();
  // alert(timecount);

    var data = {}; // define data object
    var num_q = 0;
    var answers_count = 0;
    var required_questions = 0;
    $('.tab-pane').each(function (index2) {
        num_q++;
        $(this).children("input").each(function (data) {
            if ($(this).attr("required")){
                console.log(0)
            }
        })
    });
    $(':input').each(function(index){
        if($(this).attr('type') === 'radio') {
            if ($(this).is(':checked')) {
                var Question = $(this).attr('name');

                var Answer = $(this).val() +":radio";

                data[Question] = Answer;
                answers_count++;
            } else if ($(this).is(':required')) {
                required_questions++;
            }
        } else if ($(this).attr('type') === 'text') {
            var Question = $(this).attr('name');
            var Answer = $(this).val();
            data[Question] = Answer+":text";
            answers_count++;
            if ($(this).is(':required')) {
                required_questions++;
            }
        }
    });
    var gameid=document.getElementById("game_id").value;
    var quizid=document.getElementById("quiz_id").value;
         //alert(quizid);
         data['timecount']=timecount;
        data["gameid"]=gameid;
        data["quizid"]=quizid;
        data["num_q"] = num_q;
        data["req_q"] = required_questions;
        $.ajax({
            type: 'POST',
            data: data,
            url: 'Models/Answer_Quiz.php',
            success: function (datas) {

              /*  $('.tab-content').empty().append(
                    '<div class="row">\n' +
                    '                                        <div class="col-sm-10 col-sm-offset-1">\n' +
                    '                                            <div id="answers_id">\n' +
                    '                                                    <div class="col-sm-12">\n' +
                    '                                                        <div class="choice" data-toggle="wizard-radio">\n' +
                    '                                                            <label class="element animation1 btn btn-lg btn-default btn-block text-center">\n' +
                    '                                                                <input type="radio" id="result" name ="result" disabled >\n' +
                    '                                                               <h5>Your Score : '+datas.score+'%</h5>'+
                    '                                                            </label>\n' +
                    '                                                        </div>\n' +
                    '                                                        <div class="choice" data-toggle="wizard-radio">\n' +
                    '                                                            <label class="element animation1 btn btn-lg btn-default btn-block text-center">\n' +
                    '                                                                <input type="radio" id="result" name ="result" disabled >\n' +
                    '                                                               <h5>Number of Questions : '+num_q+'</h5>'+
                    '                                                            </label>\n' +
                    '                                                        </div>\n' +
                    '                                                    </div>\';\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>'
                );*/
                 $('.tab-content').empty().append(
                 '<div class="row">\n' +
                    '                                        <div class="col-sm-10 col-sm-offset-1">\n' +
                    '                                            <div id="answers_id">\n' +
                    '                                                    <div class="col-sm-12">\n' +
                    '                                                        <div class="choice" data-toggle="wizard-radio">\n' +
                    '                                                            <label class="element animation1 btn btn-lg btn-default btn-block text-center">\n' +
                    '                                                                <input type="radio" id="result" name ="result" disabled >\n' +
                    '                                                               <h5>Game Finished</h5>'+
                    '                                                            </label>\n' +
                    '                                                        </div>\n' +
                    '                                                    </div>\';\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>'

                 );
                document.getElementById("myscore").innerHTML=datas.score+"%";
                document.getElementById("timeCounts").innerHTML=timecount;

                $('#modaldata').empty().html($('#gameOver').html());

            $(".modalDialog").css({"opacity":"1","pointer-events":"auto"});

			$('#game_rating').css('display','block ');
            $('#creditinfo').empty();
            $('#headerinfo').empty();
                $('.wizard-header').empty();
                $('.wizard-footer').empty();
            }
        });
});
