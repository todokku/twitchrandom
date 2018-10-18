import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import './StreamContainer.sass';
import StreamEmbed from '../StreamEmbed/StreamEmbed'
import { ReactComponent as Logo} from '../../logo.svg'

class StreamContainer extends Component {
  constructor(props) {
    super(props);
    this.handleGetRandom = this.handleGetRandom.bind(this);
  }
  handleGetRandom(e) {
    e.preventDefault();
    this.props.onRequestRandom(e);
  }
  render() {
    //console.log(this.props.channel);
    if(this.props.channel){
      let bannerStyle = {
        backgroundImage: `url(${this.props.channel.banner})`
      }
      return (
        <section id="stream-embed-section" style={bannerStyle}>
          <div id="stream-container">
            <StreamEmbed id="stream-embed" channel={this.props.channel.name}></StreamEmbed>
            <div id="stream-info">
              <h2 className="stream_title">{this.props.channel.title}</h2>
              <div id="stream-meta">
                <Link to={"/streams/"+this.props.channel.name} className="channel_logo">
                  <img src={this.props.channel.logo} alt={this.props.channel.name+" logo"} />
                </Link>
                <div className="channel_info">
                  <Link to={"/streams/"+this.props.channel.name} className="channel_name">
                    {this.props.channel.name}
                  </Link>
                  { (this.props.channel.game) && (
                    <div className="channel_game">
                      Playing <Link to={"/games/"+this.props.channel.game}>{this.props.channel.game}</Link>
                    </div>
                  ) }
                  <div className="channel_viewers">{this.props.channel.viewers} Viewers</div>
                </div>
              </div>
              <div id="random-stream-button">
                <Link to="/" className="main-button" title="Get Random Stream"
                  onClick={this.handleGetRandom}>
                  <Logo /> Random Stream
                </Link>
              </div>
            </div>
          </div>
        </section>
      );
    }else{
      return (
        <section id="stream-embed-section">
          <div id="stream-container">
            <div className="loading">
              <Logo />
              <div>Loading Stream</div>
            </div>
          </div>
        </section>
      );
    }
  }
}

StreamContainer.defaultProps = {
  channel: {
    name: "giantbomb8",
    title: "Giant Bomb Infinte",
    logo: "https://static-cdn.jtvnw.net/jtv_user_pictures/b93a19e9-a04b-4848-8f56-e4d44c21b221-profile_image-300x300.png",
    game: "xsy",
    viewers: 200,
    banner: "https://static-cdn.jtvnw.net/jtv_user_pictures/973a9b47-c687-41c2-b3c6-b2618fc2a678-profile_banner-480.png"
  }
};

export default StreamContainer;
