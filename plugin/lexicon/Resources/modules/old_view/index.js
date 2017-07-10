import {Button} from '#/main/core/layout/components/buttons.jsx'
import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import {Provider} from 'react-redux'
import GlossPart from './glosspart'
import GlossPerso from './glossperso'

// va chercher l'élément avec l'id lexicon
// instancie l'application react
//

class HandleEvent extends Component {

  constructor(props) {
    super(props);

    this.state = {
      ClickShare : false,
      ClickEdit : false,
      ClickDelete : false,
      password : ''
    };

    this.handValidate = this.handleValidate.bind(this);
    this.handlePassword = this.handlePassword.bind(this);
    this.handleText = this.handleText.bind(this);
    this.glossEdit = this.glossEdit.bind(this);
    this.glossDelete = this.glossDelete.bind(this);
    this.glossShare = this.glossShare.bind(this);
    //this.handleElements = this.handleElements.bind(this);
  }


  handleValidate() {
    var response = document.getElementById('gloss-pers-entry');
    //var pseudo = document.getElementById('formGroup').value;
    //var pseudopass = document.getElementById('formGroup2').value;
    console.log(response);
    //var cont = ''+ <GlossPart nom="Elvis" role="Enseignant" titre="Introduction à la lexicographie" fonction="" /> +'';
    //return response.innerHTML += '<tr id="gloss-part-entry"><td>Thomas</td><td>Etudiant</td><td>Un autre Glossaire</td><td className="glyphicons"><a href="" onClick=""><span className="fa fa-share"></span></a></td></tr>';
    return response.innerHTML += '<tr class="gloss-pers-entry" id=""><td>Mathématique appliquée</td><td class="glyphicons"><ul class="pagination"><li class=""><a href="#" onClick={this.props.edit}><span class="fa fa-pencil"></span></a></li><li class=""><a href="" onClick={this.props.share}><span class="fa fa-share"></span></a></li><li class=""><a href="" onClick={this.props.del}><span class="fa fa-trash-o"></span></a></li></ul></td></tr>';
  }

  /*handleElements(props){
    var log = this.state.login;
    var pass = this.state.password;
    return (
      <tr className="response">
        <td className="login">{log}</td>
        <td className="password">{pass}</td>
      </tr>
    );
  }*/

  handleText(event) {
    this.setState({login : event.target.value});
  }

  handlePassword(event) {
    this.setState({password : event.target.value});
  }

  glossEdit(idGloss){
    return null;
  }

  actionClick() {
    if (this.ClickDelete) {
      var response = document.getElementById('a1254');
      const ligneStyle = {
        display: 'none'
      }
      return <tr style={ligneStyle}> </tr>;
      }
  }

  glossDelete(idGloss){
    this.ClickDelete = true;

  }

  glossShare(idGloss){
    return null;
  }

  render() {

    return (
              <div className="panel-group">

                <div className="panel panel-primary">

                  <div className="panel panel-heading" id="main-gloss">
                    Mes glossaires
                  </div>

                  <div className="panel panel-body">
                    <div className="row">
                      <div className="col-md-10">
                          <div className="input-group">
                            <input id="email" type="text" className="form-control" name="email" placeholder="Recherche globale ..."/>
                             <span className="input-group-addon"><i className="fa fa-search"></i></span>
                          </div>
                      </div>

                      <div className="col-md-2">
                          <button className="btn btn-sm btn-primary" type="button" name="" id="creer-gloss" onClick={this.handleValidate}>
                            <span className="fa fa-plus"></span> <br/>Créer un glossaire
                          </button>
                      </div>
                    </div>
                  </div>

                  <div className="panel panel-footer">
                    <div className="row">


                      <div className="col-md-6" id="glos-part">
                        <div className="row">
                          <div className="panel panel-default">
                            <div className="panel panel-heading bg-primary">
                              Glossaires partagés
                            </div>

                            <div className="panel panel-body">

                                <div className="input-group">
                                  <input id="email" type="text" className="form-control" name="email" placeholder="Rechercher ..."/>
                                   <span className="input-group-addon"><i className="fa fa-search"></i></span>
                                </div><br/>


                                <div className="row">
                                  <div className="panel panel-default">

                                  <div className="panel panel-body" id="gloss-perso">

                                     <table className="table table-bordered">
                                       <thead>
                                         <tr>
                                            <th className="bg-success">Titulaires</th>
                                            <th className="bg-success">Rôles</th>
                                            <th className="bg-success">Intitulés glossaires</th>
                                            <th className="bg-success text-center">Actions</th>
                                         </tr>
                                       </thead>
                                       <tbody id="gloss-part">
                                          <GlossPart nom="Paul" role="Etudiant" titre="Anglais pour les nuls" fonction={this.glossShare(this.idGloss)} />
                                          <GlossPart nom="Eric" role="Etudiant" titre="Grammaire anglicane" fonction={this.glossShare(this.idGloss)} />
                                          <GlossPart nom="Marie" role="Etudiant" titre="Physique quantique" fonction={this.glossShare(this.idGloss)} />
                                          <GlossPart nom="Emmanuelle" role="Enseignant" titre="Espagnol pour les nuls" fonction={this.glossShare(this.idGloss)} />
                                          <GlossPart nom="Emmanuelle" role="Enseignant" titre="Linguistique générale" fonction={this.glossShare(this.idGloss)} />
                                          <GlossPart nom="Elvis" role="Enseignant" titre="Introduction à la lexicographie" fonction={this.glossShare(this.idGloss)} />
                                       </tbody>
                                     </table>
                                  </div>
                                </div>
                              </div>

                              <ul className="pagination pagination-sm">
                                <li className="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                              </ul>

                            </div>
                          </div>
                        </div>
                      </div>

                      <div className="col-md-5" id="glos-perso">
                         <div className="row">
                          <div className="panel panel-default">
                            <div className="panel panel-heading bg-primary">
                                 Mes glossaires personnels
                            </div>
                            <div className="panel panel-body">

                                <div className="input-group">
                                  <input id="email" type="text" className="form-control" name="email" placeholder="Rechercher ..."/>
                                   <span className="input-group-addon"><i className="fa fa-search"></i></span>
                                </div><br/>


                                  <div className="row">
                                 <div className="panel panel-default">

                                  <div className="panel panel-body" id="gloss-perso">


                                     <table className="table table-bordered">
                                       <thead>
                                         <tr>
                                          <th className="bg-success">Intitulés glossaires</th>
                                          <th className="bg-success text-center">Actions</th>
                                         </tr>
                                       </thead>
                                       <tbody id="gloss-pers-entry">
                                         <GlossPerso titre='Anglais pour les nuls' edit={this.glossEdit('a1254')} share={this.glossShare('a1254')} del={this.glossDelete('a1254')} idGloss="a1254"/>
                                         <GlossPerso titre='Grammaire anglicane' edit={this.glossEdit('a1254')} share={this.glossShare('a1254')} del={this.glossDelete('a1254')} idGloss="a1253"/>
                                         <GlossPerso titre='Physique quantique' edit={this.glossEdit('a1254')} share={this.glossShare('a1254')} del={this.glossDelete('a1254')} idGloss="a1254"/>
                                       </tbody>
                                     </table>
                                  </div>
                                </div>

                                <ul className="pagination pagination-sm">
                                  <li className="active"><a href="#">1</a></li>
                                  <li><a href="#">2</a></li>
                                  <li><a href="#">3</a></li>
                                  <li><a href="#">4</a></li>
                                  <li><a href="#">5</a></li>
                                </ul>

                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>
              </div>
      );
  }

}

const result = <div> coucoucou </div>;
ReactDOM.render(
  <HandleEvent />,
  document.getElementById('lexicon')
)
