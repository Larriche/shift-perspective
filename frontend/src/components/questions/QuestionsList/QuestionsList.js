import React from 'react';

import QuestionItem from './../QuestionItem/QuestionItem';
import './QuestionsList.css';

function QuestionsList(props) {
    return (
        (
            (props.questions && props.questions.length) ?
            <section id="questions">
                {props.questions.map(question => (
                    <QuestionItem
                        key={question.id}
                        id={question.id}
                        question={question}
                        onQuestionResponded={props.onQuestionResponded}
                    />
                ))}
            </section> :
            <section>
                <p className="QuestionsLoading">No questions loaded yet ...</p>
            </section>
        )
    )
}

export default QuestionsList;