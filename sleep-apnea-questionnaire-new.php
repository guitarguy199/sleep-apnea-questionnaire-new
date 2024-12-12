<?php
/*
Plugin Name: Sleep Apnea Questionnaire V2
Description: A simple plugin to calculate sleep apnea risk.
Version: 2.0
Author: Austin O'Neil - ProspectaMarketing
*/

function saq_display_form() {
    ob_start();
    ?>
<style>
    #saq-trigger {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3182CE;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    }
    #saq-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    z-index: 1000;
    display: none;
    }
    #saq-content {
    position: relative;
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 600px;
    max-width: 90%;
    height: 500px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }
    .close-button {
    position: absolute;
    top: 10px;
    right: 20px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #000000;
    }
    .question {
    display: none;
    width: 100%;
    }
    .question.active {
    display: flex;
    flex-direction: column;
    align-items: center;
    }
    .next-button, .back-button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #5a67d8;
    color: white;
    border: none;
    cursor: pointer;
    text-decoration: none;
    }
    .back-button {
    background-color: #718096;
    margin-right: 10px;
    }
    .result-message {
    display: none;
    font-size: 1.5em;
    font-weight: bold;
    }
    .result-message.active {
    display: block;
    }
    .contact-button {
    display: none;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #f56565;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    }
    
    .contact-button.active {
    display: inline-block;
    }
    
    #consultation-message {
    display: none;
    font-size: 1.2em;
    margin-top: 20px;
    }
    
    .result-low {
    color: green;
    }
    .result-medium {
    color: orange;
    }
    .result-high {
    color: red;
    }
    
    .button-group {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }
    
    input[type="radio"] {
    display: none;
    }
    input[type="radio"] + label {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    }
    input[type="radio"]:checked + label {
    background-color: #5a67d8;
    color: white;
    border-color: #5a67d8;
    }
    .radio-group {
    display: flex;
    justify-content: center;
    margin-top: 10px;
    }
    /* Remove number input spinners */
    input[type=number] {
        -moz-appearance: textfield;
    }
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>

<button id="saq-trigger">Start Questionnaire</button>

<div id="saq-lightbox">
    <div id="saq-content">
        <button class="close-button" id="close-lightbox">X</button>
        <div id="question-1" class="question active">
            <p>1. Do you Snore Loudly (loud enough to be heard through closed doors or your bed-partner elbows you for snoring at night)?</p>
            <div class="radio-group">
                <input type="radio" id="q1-yes" name="q1" value="yes">
                <label for="q1-yes">Yes</label>
                <input type="radio" id="q1-no" name="q1" value="no" checked>
                <label for="q1-no">No</label>
            </div>
            <div class="button-group">
                <button class="next-button" data-next="question-2">Next</button>
            </div>
        </div>
        <div id="question-2" class="question">
            <p>2. Do you often feel Tired, Fatigued, or Sleepy during the daytime (such as falling asleep during driving or talking to someone)?</p>
            <div class="radio-group">
                <input type="radio" id="q2-yes" name="q2" value="yes">
                <label for="q2-yes">Yes</label>
                <input type="radio" id="q2-no" name="q2" value="no" checked>
                <label for="q2-no">No</label>
            </div>
            <div class="button-group">
                <button class="back-button" data-back="question-1">Back</button>
                <button class="next-button" data-next="question-3">Next</button>
            </div>
        </div>
        <div id="question-3" class="question">
            <p>3. Has anyone Observed you Stop Breathing or Choking/Gasping during your sleep?</p>
            <div class="radio-group">
                <input type="radio" id="q3-yes" name="q3" value="yes">
                <label for="q3-yes">Yes</label>
                <input type="radio" id="q3-no" name="q3" value="no" checked>
                <label for="q3-no">No</label>
            </div>
            <div class="button-group">
                <button class="back-button" data-back="question-2">Back</button>
                <button class="next-button" data-next="question-4">Next</button>
            </div>
        </div>
        <div id="question-4" class="question">
            <p>4. Do you have or are you being treated for high blood pressure?</p>
            <div class="radio-group">
                <input type="radio" id="q4-yes" name="q4" value="yes">
                <label for="q4-yes">Yes</label>
                <input type="radio" id="q4-no" name="q4" value="no" checked>
                <label for="q4-no">No</label>
            </div>
            <div class="button-group">
                <button class="back-button" data-back="question-3">Back</button>
                <button class="next-button" data-next="question-5">Next</button>
            </div>
        </div>
        <div id="question-5" class="question">
            <p>5. Are you older than 50?</p>
            <div class="radio-group">
                <input type="radio" id="q5-yes" name="q5" value="yes">
                <label for="q5-yes">Yes</label>
                <input type="radio" id="q5-no" name="q5" value="no" checked>
                <label for="q5-no">No</label>
            </div>
            <div class="button-group">
                <button class="back-button" data-back="question-4">Back</button>
                <button class="next-button" data-next="question-6">Next</button>
            </div>
        </div>
        <div id="question-6" class="question">
            <p>6. Do you have a large neck size? (is your shirt collar 16 inches / 40 cm or larger?)</p>
            <div class="radio-group">
                <input type="radio" id="q6-yes" name="q6" value="yes">
                <label for="q6-yes">Yes</label>
                <input type="radio" id="q6-no" name="q6" value="no" checked>
                <label for="q6-no">No</label>
            </div>
            <div class="button-group">
                <button class="back-button" data-back="question-5">Back</button>
                <button class="next-button" data-next="question-7">Next</button>
            </div>
        </div>
        <div id="question-7" class="question">
            <p>7. Are you biologically male?</p>
            <div class="radio-group">
                <input type="radio" id="q7-yes" name="q7" value="yes">
                <label for="q7-yes">Yes</label>
                <input type="radio" id="q7-no" name="q7" value="no" checked>
                <label for="q7-no">No</label>
            </div>
            <div class="button-group">
                <button class="back-button" data-back="question-6">Back</button>
                <button class="next-button" data-next="question-8">Next</button>
            </div>
        </div>
        <div id="question-8" class="question">
            <p>8. Please enter your height and weight for BMI calculation.</p>
            <label>Height: <input type="number" id="height-feet" placeholder="feet" style="width: 120px;"> ft <input type="number" id="height-inches" placeholder="inches" style="width: 120px;"> in</label>
            <br>
            <label>Weight: <input type="number" id="weight" placeholder="lbs" style="width: 120px;"> lbs</label>
            <div class="button-group">
                <button class="back-button" data-back="question-7">Back</button>
                <button id="calculate-risk" class="next-button">Calculate Risk</button>
            </div>
        </div>
        <div id="saq-result" class="result-message"></div>
        <div id="consultation-message" class="question result-message">
            <p>We advise contacting our specialists to set up a consultation.</p>
        </div>
        <a href="/contact-us/" id="contact-button" class="contact-button">Contact Us</a>
    </div>
</div>

<script>
    function resetQuestionnaire() {
        // Reset all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            radio.checked = false;
        });
        // Set 'No' as default for all questions
        document.querySelectorAll('input[type="radio"][value="no"]').forEach(function(radio) {
            radio.checked = true;
        });
        // Reset height and weight inputs
        document.getElementById('height-feet').value = '';
        document.getElementById('height-inches').value = '';
        document.getElementById('weight').value = '';
        // Reset visibility of questions and result messages
        document.querySelectorAll('.question').forEach(function(question) {
            question.classList.remove('active');
        });
        document.querySelectorAll('.result-message').forEach(function(resultMessage) {
            resultMessage.classList.remove('active');
        });
        document.getElementById('consultation-message').style.display = 'none';
        document.getElementById('contact-button').style.display = 'none';
        // Activate the first question
        document.getElementById('question-1').classList.add('active');
    }

    document.getElementById('saq-trigger').addEventListener('click', function() {
        document.getElementById('saq-lightbox').style.display = 'flex';
        resetQuestionnaire();
    });
    document.getElementById('close-lightbox').addEventListener('click', function() {
        document.getElementById('saq-lightbox').style.display = 'none';
        resetQuestionnaire();
    });

    document.querySelectorAll('.next-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var current = this.parentElement.parentElement;
            var next = document.getElementById(this.getAttribute('data-next'));
            current.classList.remove('active');
            next.classList.add('active');
        });
    });

    document.querySelectorAll('.back-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var current = this.parentElement.parentElement;
            var back = document.getElementById(this.getAttribute('data-back'));
            current.classList.remove('active');
            back.classList.add('active');
        });
    });

    document.getElementById('calculate-risk').addEventListener('click', function() {
        var score = 0;
        var firstFourScore = 0;
        var isMale = document.getElementById('q7-yes').checked;
        var isLargeNeckCircumference = document.getElementById('q6-yes').checked;
        var isHighBMI = false;

        if (document.getElementById('q1-yes').checked) {
            score++;
            firstFourScore++;
        }
        if (document.getElementById('q2-yes').checked) {
            score++;
            firstFourScore++;
        }
        if (document.getElementById('q3-yes').checked) {
            score++;
            firstFourScore++;
        }
        if (document.getElementById('q4-yes').checked) {
            score++;
            firstFourScore++;
        }
        if (document.getElementById('q5-yes').checked) {
            score++;
        }
        if (document.getElementById('q6-yes').checked) {
            score++;
        }
        if (document.getElementById('q7-yes').checked) {
            score++;
        }

        var heightFeet = parseInt(document.getElementById('height-feet').value) || 0;
        var heightInches = parseInt(document.getElementById('height-inches').value) || 0;
        var weight = parseInt(document.getElementById('weight').value) || 0;

        var heightTotalInches = (heightFeet * 12) + heightInches;
        var bmi = (weight / (heightTotalInches * heightTotalInches)) * 703;

        if (bmi > 35) {
            isHighBMI = true;
        }

        var risk = 'Low Risk';
        if (score >= 5 || 
            (firstFourScore >= 2 && isMale) || 
            (firstFourScore >= 2 && isLargeNeckCircumference) || 
            (firstFourScore >= 2 && isHighBMI)) {
            risk = 'High Risk';
        } else if (score >= 3) {
            risk = 'Medium Risk';
        }

        var resultElement = document.getElementById('saq-result');
        var consultationMessage = document.getElementById('consultation-message');
        var contactButton = document.getElementById('contact-button');

        resultElement.classList.remove('result-low', 'result-medium', 'result-high');

        if (risk === 'High Risk') {
            resultElement.innerHTML = 'High Risk of Sleep Apnea';
            resultElement.classList.add('result-high');
            consultationMessage.style.display = 'block';
            contactButton.style.display = 'inline-block';
        } else if (risk === 'Medium Risk') {
            resultElement.innerHTML = 'Medium Risk of Sleep Apnea';
            resultElement.classList.add('result-medium');
            consultationMessage.style.display = 'block';
            contactButton.style.display = 'inline-block';
        } else {
            resultElement.innerHTML = 'Low Risk of Sleep Apnea';
            resultElement.classList.add('result-low');
            consultationMessage.style.display = 'none';
            contactButton.style.display = 'none';
        }

        resultElement.classList.add('active');
    });
</script>
<?php
return ob_get_clean();
}

add_shortcode('saq_form', 'saq_display_form');
?>
