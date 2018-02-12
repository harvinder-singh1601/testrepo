<?php
include 'dbConfig.php';
$page_title = "Quiz-Creation";
$page_description = "Create Quiz Game";
include("header.php");
$quiz="select * from Quiz where game_id='".$_REQUEST['id']."'";
$query_rs=mysqli_query($db,$quiz) or die("Cannot Execute Query".mysqli_error($db));
$query_row=mysqli_fetch_array($query_rs);

?>
    <!-- Bootstrap -->
    <!-- <link href="assets_quiz/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="assets_quiz/css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet"> -->
    <!-- <link href="assets_quiz/css/style.css" rel="stylesheet"> -->
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <div class="container" >
        <div class="content" style="background-color:#f4f7f8;color:black !important;">
            <form id="quiz_form" action="#" class="form-horizontal" class="form-style-5" method="get">
            <div class="col-xs-3">
                    <a href="edit_game_quiz.php?id=<?php echo $_REQUEST['id']?>">Back To Previous Step</a>

                </div>
                <div class="col-xs-12">
                    <h3 class="add-quiz-title">Add Quiz</h3>
                </div>
                <div class="form-group">
                    <label for="survey_name" class="col-sm-2 control-label">Quiz Name : </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="survey_name" name="survey_name" placeholder="Enter Quiz Name" value="<?php echo $query_row['Quiz_name']?>" required="required">
                    </div>
                </div>
                <div class="col-xs-10 col-sm-offset-2 custom-tick">
                    <input type="checkbox" name="isRandomized" id="isRandomized" <?php if($query_row['Quiz_randomized']==1) echo "checked";?> > Randomize questions ?!
                </div>
                <div class="col-xs-12">
                    <h3 class="add-quiz-title">Questions</h3>
                </div>
                <div class="questions-list">
                <?php
                 $Question="select * from Question where Question_Quiz_id='".$query_row['Quiz_id']."' order by Question_id asc";
                $Question_rs=mysqli_query($db,$Question) or die("Cannot Execute Query".mysqli_error($db));
                if(mysqli_num_rows($Question_rs)>0)
                {

                    $questioncount=0;
                    while($question_row=mysqli_fetch_array($Question_rs))
                    {
                        $questioncount=$questioncount+1;
                        ?>
                        <div class="question">
                        <div class="col-md-4 col-xs-12">
                            <h4 class="add-quiz-title">Question</h4>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="list-options pull-right">
                                <button class="option" id="question_up"><i class="fa fa-arrow-up"></i>Move Up</button>
                                <button class="option" id="question_down"><i class="fa fa-arrow-down"></i> Move Down</button>
                                <button class="option" id="delete_question"><i class="fa fa-trash"></i> Delete Question</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_type" class="col-sm-2 control-label">Question Type : </label>
                            <div class="col-sm-4">
                                <select name="question_type[]" id="question_type" class="form-control">
                                    <option <?php if($question_row['Question_type']=="many") echo "selected";?> value="many">Select Many</option>
                                    <option <?php if($question_row['Question_type']=="one") echo "selected";?> value="one">Enter One</option>
                                </select>
                            </div>
                            <div class="col-md-3 custom-tick">
                                <input type="checkbox" <?php if($question_row['Question_isRequired']=="1") echo "checked";?> name="Isrequired[]" value="on" id="Isrequired" > Required Question
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_text" class="col-sm-2 control-label">Question Text : </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="question_text" name="question_text[]" value="<?php echo $question_row['Question_text']?>" placeholder="Enter Question Text" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_text" class="col-sm-2 control-label">Question Image : </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="question_image" name="question_image[]">
                                <?php
                                if($question_row['Question_image'])
                                {
                                    echo "<img src='".$question_row['Question_image']."' width='50px' height='50px'>";
                                    echo "<input type='hidden' name='question_oldimage[]' id='question_oldimage' value='".$question_row['Question_image']."'>";
                                }
                                ?>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                            </div>
                        </div>
                        <div class="choices">
                            <div class="col-md-10 col-xs-12 col-md-offset-2">
                                <h4>Choices</h4>
                            </div>
                            <?php
                            $Answer="select * from Answers where Answer_Question_id='".$question_row['Question_id']."'";
                            $answer_rs=mysqli_query($db,$Answer) or die("Cannot Execute Query".mysqli_error($db));
                            if(mysqli_num_rows($answer_rs)>0)
                            {
                                $count=0;
                                while($answer_row=mysqli_fetch_array($answer_rs))
                                {
                                    $count=$count+1;
                                    ?>
                            <div class="choice">
                                <div class="form-group">
                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" value="<?php echo $answer_row['Answer_text']?>" required="required">
                                    </div>
                                    <div class="col-sm-2 custom-tick">
                                        <input type="checkbox" id="rightAnswer" <?php if($answer_row['Answer_isRight']==1) echo "checked";?> name="rightAnswer[]" value="on"> Right Answer
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>
                                    </div>
                                </div>
                            </div>
                                    <?php

                                }
                            }
                            else
                            {
                                if($question_row['Question_type']=="many") $count=2;
                                else $count=1;

                                for($m=1;$m<=$count;$m=$m+1)
                                {
                                ?>
                                <div class="choice">
                                <div class="form-group">
                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">
                                    </div>
                                    <div class="col-sm-2 custom-tick">
                                        <input type="checkbox" id="rightAnswer" name="rightAnswer[]" checked="true" value="on"> Right Answer
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>
                                    </div>
                                </div>
                            </div>

                                <?php
                                }

                            }

                            ?>


                            <input type="hidden" value="<?php echo $count;?>" name="choice_count[]" id="choice_count">
                        </div>
                        <div class="col-sm-10 col-md-offset-2">
                        <?if($count>=2){?>
                            <button class="option" id="add_choice"><i class="fa fa-plus"></i> Add Choice</button>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                        <?php
                    }
                }
                else
                {
                    $questioncount=1;

                ?>
                    <div class="question">
                        <div class="col-md-4 col-xs-12">
                            <h4 class="add-quiz-title">Question</h4>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="list-options pull-right">
                                <button class="option" id="question_up"><i class="fa fa-arrow-up"></i> Move Up</button>
                                <button class="option" id="question_down"><i class="fa fa-arrow-down"></i> Move Down</button>
                                <button class="option" id="delete_question"><i class="fa fa-trash"></i> Delete Question</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_type" class="col-sm-2 control-label">Question Type : </label>
                            <div class="col-sm-4">
                                <select name="question_type[]" id="question_type" class="form-control">
                                    <option value="many">Select Many</option>
                                    <option value="one">Enter One</option>
                                </select>
                            </div>
                            <div class="col-md-3 custom-tick">
                                <input type="checkbox" name="Isrequired[]" value="on" id="Isrequired" > Required Question
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_text" class="col-sm-2 control-label">Question Text : </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="question_text" name="question_text[]" placeholder="Enter Question Text" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_text" class="col-sm-2 control-label">Question Image : </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="question_image" name="question_image[]">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                            </div>
                        </div>
                        <div class="choices">
                            <div class="col-md-10 col-xs-12 col-md-offset-2">
                                <h4>Choices</h4>
                            </div>
                            <div class="choice">
                                <div class="form-group">
                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">
                                    </div>
                                    <div class="col-sm-2 custom-tick">
                                        <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on"> Right Answer
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>
                                    </div>
                                </div>
                            </div>
                            <div class="choice">
                                <div class="form-group">
                                    <label for="choice" class="col-sm-2 control-label">Choice: </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">
                                    </div>
                                    <div class="col-sm-2 custom-tick">
                                        <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on"> Right Answer
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="option" id="delete_choice"><i class="fa fa-trash"></i> Delete Choice</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="2" name="choice_count[]" id="choice_count">
                        </div>
                        <div class="col-sm-10 col-md-offset-2">
                            <button class="option" id="add_choice"><i class="fa fa-plus"></i> Add Choice</button>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <input type="hidden" value="<?php echo $questioncount;?>" name="questions_count[]" id="question_count" >
                </div>
                <div class="col-xs-12">
                    <button class="option" id="add_question" ><i class="fa fa-plus"></i> Add Question</button>
                </div>
                <hr class="divider">
                <div class="col-xs-12 col-md-10 col-md-offset-2">
                    <div class="pull-right">
                        <button class="option"><i class="fa fa-trash"></i> Delete Quiz</button>
                        <button class="option" id="save-quiz"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" name="game_id" id="game_id" value="<?php echo $_REQUEST['id']?>">
    <input type="hidden" name="quiz_id" id="quiz_id" value="<?php echo $query_row['Quiz_id']?>">
<script src="assets_quiz/js/jquery.min.js"></script>
<script src="assets_quiz/js/bootstrap.min.js"></script>
<script src="assets_quiz/js/custom.js"></script>
</div>
</div>
<?php include "footer.php";?>
