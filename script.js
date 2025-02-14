document.addEventListener('DOMContentLoaded', function() { //DOMContentLoaded laster full ut nettleseren 
    let questionCount = 0; // Hvor mange spørsmåler det er nå.

    function addQuestion() { // La brukeren lage et spørsmål i nettsiden
      questionCount++;
      const questionsContainer = document.getElementById('questionsContainer');
      
      // Lage et element og putte det i HTML og putte det i variablen questionCount.
      const questionDiv = document.createElement('div');
      questionDiv.className = 'question'; 
      questionDiv.id = 'question-' + questionCount; 
      

      const questionLabel = document.createElement('label');
      questionLabel.innerText = 'Question ' + questionCount + ':';
      const questionInput = document.createElement('input');
      questionInput.type = 'text';
      questionInput.name = 'question' + questionCount;
      questionInput.required = true;
      
      questionDiv.appendChild(questionLabel);
      questionDiv.appendChild(document.createElement('br'));
      questionDiv.appendChild(questionInput);
      questionDiv.appendChild(document.createElement('br'));
      
      const answersContainer = document.createElement('div');
      answersContainer.id = 'answersContainer-' + questionCount;
      questionDiv.appendChild(answersContainer);
      
      const addAnswerButton = document.createElement('button');
      addAnswerButton.type = 'button';
      addAnswerButton.innerText = 'Add Answer';
      addAnswerButton.addEventListener('click', function() {
        addAnswer(questionCount);
      });
      questionDiv.appendChild(addAnswerButton);
      
      questionsContainer.appendChild(questionDiv);
    }
    
    function addAnswer(questionId) {
      const answersContainer = document.getElementById('answersContainer-' + questionId);
      const answerCount = answersContainer.childElementCount + 1;
      
      const answerDiv = document.createElement('div');
      answerDiv.className = 'answer';
      
      const answerLabel = document.createElement('label');
      answerLabel.innerText = 'Answer ' + answerCount + ':';
      const answerInput = document.createElement('input');
      answerInput.type = 'text';
      answerInput.name = 'question' + questionId + '_answer' + answerCount;
      answerInput.required = true;
      
      answerDiv.appendChild(answerLabel);
      answerDiv.appendChild(document.createElement('br'));
      answerDiv.appendChild(answerInput);
      answerDiv.appendChild(document.createElement('br'));
      
      answersContainer.appendChild(answerDiv);
    }
    
    document.getElementById('addQuestionButton').addEventListener('click', addQuestion);
  });