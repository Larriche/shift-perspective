import React from 'react';

import QuestionItem from './../QuestionItem/QuestionItem';
import './QuestionsList.css';

function QuestionsList(props) {
    return (
        <section id="questions">
            {props.questions.map(question => (
                <QuestionItem
                  key={question.id}
                  id={question.id}
                  question={question}
                  onQuestionResponded={props.onQuestionResponded}
                />
            ))}
        </section>
    )
}

export default QuestionsList;