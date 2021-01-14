import './QuestionItem.css';

function QuestionItem(props) {
    return (
        <section className="QuestionCard">
            <p>{ props.question.question }</p>

            <section className="QuestionControls">
                <ul>
                    <li className="Disagree">Disagree</li>

                    {[...Array(7)].map((e, i) =>
                    <li key={`${props.question.id}-${i}`}>
                        <input type="radio"
                        name={`${props.question.id}-input`}
                        value={i + 1}
                        onClick={props.onQuestionResponded.bind(null, props.question, i + 1)}></input></li>)}

                    <li className="Agree">Agree</li>
                </ul>
            </section>
        </section>
    )
}

export default QuestionItem;