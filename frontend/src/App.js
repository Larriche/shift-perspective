import React, { Component } from 'react';
import swal from '@sweetalert/with-react'
import QuestionsList from './components/questions/QuestionsList/QuestionsList';
import Results from './components/results/Results';

import './App.css';
class App extends Component {
  state = {
    questions: [],
    responses: {},
    email: '',
    results: null
  }

  constructor(props) {
    super(props)
    this.recordAnswer = this.recordAnswer.bind(this)
    this.emailChangeHandler = this.emailChangeHandler.bind(this)
    this.validateResponses = this.validateResponses.bind(this)
    this.submitForm = this.submitForm.bind(this)
    this.saveResponses = this.saveResponses.bind(this)
    this.displayErrorMessages = this.displayErrorMessages.bind(this);
  }

  submitForm() {
    let responsesValidated = this.validateResponses();

    if (responsesValidated) {
      if (this.state.email) {
        swal({
          title: "Confirm Form Submission",
          text: "Are you sure you want to submit your responses?",
          icon: "info",
          buttons: ['No', 'Yes'],
          dangerMode: false,
        })
        .then(response => {
          if (response) {
            this.saveResponses();
          }
        });
      } else {
        swal({
          title: "Please provide email",
          text: "Please enter your email",
          icon: "error",
          dangerMode: true,
        })
      }
    } else {
      swal({
        title: "Answer all questions",
        text: "Some questions have not been answered. Please check them",
        icon: "error",
        dangerMode: true,
      })
    }
  }

  saveResponses() {
    let status = null;

    fetch('http://127.0.0.1:8000/api/mbti', {
      method: 'POST',
      body: JSON.stringify({
        responses: Object.values(this.state.responses),
        email: this.state.email
      }),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(res => {
      status = res.status;
      return res.json()
    })
    .then(res => {
      if (status === 201) {
        this.setState(state => {
          return {
            email: state.email,
            responses: state.responses,
            questions: state.questions,
            results: res
          }
        })
      } else {
        if (status === 422) {
          this.displayErrorMessages(res.errors);
        }
      }
    })
  }

  refreshForm() {
    window.location.reload();
  }

  componentDidMount() {
    fetch('http://127.0.0.1:8000/api/questions')
      .then(res => res.json())
      .then(data => {
        this.setState({ questions: data })
      })
      .catch(error => console.log(error))
  }

  emailChangeHandler(event) {
    this.setState(state => {
      return {
        email: event.target.value,
        responses: state.responses,
        questions: state.questions
      }
    })
  }

  recordAnswer(question, choice) {
    this.setState(state => {
      let responses = state.responses;

      if (!responses[question.id]) {
        responses[question.id] = {
          question_id: question.id,
          dimension: question.dimension,
          direction: question.direction
        }
      }

      responses[question.id]['choice'] = choice;

      return {
        questions: state.questions,
        email: state.email,
        responses
      };
    })
  }

  validateResponses() {
    for (let question of this.state.questions) {
      if (!this.state.responses[question.id]) {
        return false;
      }
    }

    return true;
  }

  displayErrorMessages(errors) {
    let errorsMessage = '';

    for (let errorGroup of Object.values(errors)) {
      for (let error of errorGroup) {
        errorsMessage += `${error}\n`;
      }
    }

    swal({
      title: "Errors",
      text: errorsMessage,
      icon: "error",
      dangerMode: true
    })
  }

  render() {
    return (
      !this.state.results ?
      (<section>
        <section id="heading">
          <h3>Discover Your Perspective</h3>
          <p>Complete the 7 min test and get a detailed report of your lenses on the world</p>
        </section>

        <QuestionsList questions={this.state.questions} onQuestionResponded={this.recordAnswer}></QuestionsList>

        <section id="email">
          <h3>Your Email</h3>
          <input type="text" placeholder="you@example.com" onChange={this.emailChangeHandler}></input>
        </section>

        <section className="ButtonDiv">
          <button onClick={this.saveResponses}>Save and Continue</button>
        </section>
      </section>) : (
        <section>
          <Results results={this.state.results}></Results>

          <section className="ButtonDiv">
            <button onClick={this.refreshForm}>Fill in another response</button>
          </section>
        </section>
      )
    )
  }
}

export default App;
