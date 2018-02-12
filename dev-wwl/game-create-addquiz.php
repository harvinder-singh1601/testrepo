<?php 
include 'dbConfig.php';
$page_title = "Quiz Questions";
$page_description = "Add questions to the Quiz";
include("header.php"); 
$quiz="select * from Quiz where game_id='".$_REQUEST['id']."'";
$query_rs=mysqli_query($db,$quiz) or die("Cannot Execute Query".mysqli_error($db));
$query_row=mysqli_fetch_array($query_rs);

?>
<!--==Game Creation: Add Quiz Page==-->
			<div class="add-quiz-page">
				<div class="aqContent">
					<div class="aqcHead">
					  <a href="game-create-quiz.php">Previous Page</a>
						<h2>Add Quiz</h2>
						<div class="qName">
							<label>Quiz Name</label>
							<input type="text" id="survey_name" name="survey_name" value="<?php echo $query_row['Quiz_name']?>" placeholder="Enter Quiz Name"  required>
						</div>

						<div class="randomQ custom-tick">
							<input type="checkbox" name="isRandomized" id="isRandomized" <?php if($query_row['Quiz_randomized']==1) echo "checked";?>>
							<label>Randomize Questions?</label>
						</div>
					</div>

					<div class="questionArea">
						<h2>Questions</h2>
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
						<div class="eachQuestion-area">
							<div class="eachQuestion">
								<div class="eqHead">
									<h3>Question</h3>
									<div class="qAction">
										<a href="#" id="question_up">Move Up</a>
										<a href="#" id="question_down">Move Down</a>
										<a href="#" id="delete_question" class="delete-question">Delete Question</a>
									</div>
								</div>
								<div class="eqContent">
									<div class="qcrow">
										<div class="qType">
											<label>Question Type</label>
					                      <select name="question_type[]" id="question_type" class="form-control">
                                                <option <?php if($question_row['Question_type']=="many") echo "selected";?> value="many">Select Many</option>
                                                <option <?php if($question_row['Question_type']=="one") echo "selected";?> value="one">Enter One</option>
                                        </select>
										</div>

										<div class="rqCheck custom-tick">
											 <input type="checkbox" <?php if($question_row['Question_isRequired']=="1") echo "checked";?> name="Isrequired[]" value="on" id="Isrequired" >
                            
											<label>Required Question</label>
										</div>
									</div>

									<div class="qText">
										<label>Question Text</label>
										 <input type="text" class="form-control" id="question_text" name="question_text[]" value="<?php echo $question_row['Question_text']?>" placeholder="Enter Question Text" required="required">
                           
									</div>
									<div class="qImage">
										<label>Question Image</label>
										<input type="file" class="form-control" id="question_image" name="question_image[]">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                                <?php
                                if($question_row['Question_image'])
                                {
                                    echo "<img src='".$question_row['Question_image']."' width='50px' height='50px'>";
                                    echo "<input type='hidden' name='question_oldimage[]' id='question_oldimage' value='".$question_row['Question_image']."'>";
                                }
                                ?>
									</div>
								</div>

								<div class="qChoice">
									<h3>Choices</h3>
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
									<div class="eachChoice">
										<div class="ecText">
											<label>Choice:</label>
											<input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" value="<?php echo $answer_row['Answer_text']?>" required="required">
                                    
										</div>
										<div class="ecCheck custom-tick">
											<input type="checkbox" id="rightAnswer" <?php if($answer_row['Answer_isRight']==1) echo "checked";?> name="rightAnswer[]" value="on"> 
                                   
											<label>Right Answer</label>
										</div>
										<a href="#" class="dlt-choice" id="delete_choice">Delete Choice</a>
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
									<div class="eachChoice">
										<div class="ecText">
											<label>Choice:</label>
											<input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">
                                    
										</div>
										<div class="ecCheck custom-tick">
											<input type="checkbox" id="rightAnswer" name="rightAnswer[]" checked="true" value="on">
											<label>Right Answer</label>
										</div>
										<a href="#" id="delete_choice" class="dlt-choice">Delete Choice</a>
									</div>
         <?php
                                }
                                
                            }
                            
                            ?>
								</div>
                                <input type="hidden" value="<?php echo $count;?>" name="choice_count[]" id="choice_count">
								<a href="#" class="add-choice">Add Choice</a>
							</div>
						</div>
       <?php
                    }
                }
                else
                {
                    $questioncount=1;
                
                ?>
                <div class="eachQuestion-area">
							<div class="eachQuestion">
								<div class="eqHead">
									<h3>Question</h3>
									<div class="qAction">
										<a href="#" id="question_up">Move Up</a>
										<a href="#" id="question_down">Move Down</a>
										<a href="#" id="delete_question" class="delete-question">Delete Question</a>
									</div>
								</div>
								<div class="eqContent">
									<div class="qcrow">
										<div class="qType">
											<label>Question Type</label>
											<select name="question_type[]" id="question_type" class="form-control">
                                    <option value="many">Select Many</option>
                                    <option value="one">Enter One</option>
                                </select>
										</div>

										<div class="rqCheck custom-tick">
											<input type="checkbox" name="Isrequired[]" value="on" id="Isrequired" > 
											<label>Required Question</label>
										</div>
									</div>

									<div class="qText">
										<label>Question Text</label>
										<input type="text" class="form-control" id="question_text" name="question_text[]" placeholder="Enter Question Text" required="required">
                           
									</div>
									<div class="qImage">
										<label>Question Image</label>
										<input type="file" class="form-control" id="question_image" name="question_image[]">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
									</div>
								</div>

								<div class="qChoice">
									<h3>Choices</h3>
									<div class="eachChoice">
										<div class="ecText">
											<label>Choice:</label>
											<input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">
                                    
										</div>
										<div class="ecCheck custom-tick">
											 <input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on">
											<label>Right Answer</label>
										</div>
										<a href="#" id="delete_choice" class="dlt-choice">Delete Choice</a>
									</div>
									<div class="eachChoice">
										<div class="ecText">
											<label>Choice:</label>
											<input type="text" class="form-control" id="choice" name="choice[]" placeholder="Enter Answer" required="required">
                                    
										</div>
										<div class="ecCheck custom-tick">
											<input type="checkbox" id="rightAnswer" name="rightAnswer[]" value="on">
											<label>Right Answer</label>
										</div>
										<a href="#" id="delete_choice" class="dlt-choice">Delete Choice</a>
									</div>
                                    <input type="hidden" value="2" name="choice_count[]" id="choice_count">
								</div>
								<a href="#" id="add_choice" class="add-choice">Add Choice</a>
							</div>
						</div>
                        <?php
                        }
                        ?>
<input type="hidden" value="<?php echo $questioncount;?>" name="questions_count[]" id="question_count" >
						<a href="#"  id="add_question" class="add-question">Add Question</a>

						<div class="qestionAction">
							<a href="#" class="delete-quiz">Delete Quiz</a>
							<a href="#" id="save-quiz" class="save-quiz">Save</a>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	<!--== Footer Area==-->	
    <script src="assets_quiz/js/jquery.min.js"></script>
<script src="assets_quiz/js/bootstrap.min.js"></script>
<script src="assets_quiz/js/custom.js"></script>	
		<?php include("footer.php"); ?>