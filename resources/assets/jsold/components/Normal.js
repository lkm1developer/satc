import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Main extends Component {
    render() {
        return (
         <section>   
		<div className="main_header">
        <div className="inner">
        <div className="logo">
        <a href="index.html"><img src="images/heart-logo-for-mediccoin-version-2-e1516114583235.png"/></a>
        <a href="index.html">Crypto that Promotes Health and Philanthropy</a>
       
        </div>
        <div className="right_head">
        <div className="statistics">
        <a href="index.html"><i className="fa fa-globe" aria-hidden="true"></i>Statistics
        </a>
        </div>
        <div className="master_node">
        <a href="master_node.html"><i className="fa fa-th-list"></i> My  Masternodes</a>
        </div>
        <div className="faq_part">
        <a href="faq_page.html"><i className="fa fa-question-circle"></i> FAQ</a>
        </div>
        </div>
        </div>
    
    </div>
    <div className="slider_maun">
        <div className="inner">
            <div className="slider_section">
            <h1>Medicc</h1><span><img src="images/heart-logo-for-mediccoin-version-2-e1516114583235.png"/></span><h1>in</h1>
            <p>The base currency of the MEDICCION Platform, masternodes are available since block 200.</p>
            <div className="contact_join">
            <a href="" className="btn_contact">contact us</a>
            <a href="" className="btn_contact">join us</a>
            </div>
            </div>
        </div>
    </div>
    
    <div className="mediccoin_launch">
        <div className="inner">
        <div className="container">
            <div className="image_medicoin">
            <img src="images/circ3-502x502-502x502.png"/>
            </div>
            <div>
            <h2>Mediccoin</h2>
            </div>
            <div className="paragraph_medicoin">
            <p>MedicCoin (MEDIC) is a community-driven crypto focused on improving the health of people throughout 
            the world via innovative reward programs, recruiting others to help advance scientific research and 
            donating to charities. Also, because it uses proof of stake to secure the network, MedicCoin is far more 
            environmentally friendly and efficient than other cryptos that consume mass amounts of energy every day.</p>
            </div>
            <div className="launch_host_web">
            <button>Launch Masternode</button>
            <button>Hosted masternode: 45</button>
            <p className="web_explorer_btn"><button className="btn_web">Website  <span className="glyphicon glyphicon-share"></span></button>
            <span className="vertical_line"></span>
            <button className="btn_explorer">Explorer <span className="glyphicon glyphicon-share"></span></button>
            </p>
            </div>
        
        </div>
    </div>
    </div>
        <div className="reliable_medic">
            <div className="inner">
                <div className="medicoin_wallet">
                <h3>Choose a Reliable Medic Coin Wallet</h3>
                <p>Please select one of the following MedicCoin wallets to install.  MedicCoin iOS wallet is coming July 2018.</p>
                </div>
                <div className="window_wallet">
                <ul>
                <li className="window_section">
                <div className="section_img">
                <img src="images/Windows-Logo-Icon-winlogo-big-01.png"/>
                <h5>Windows Wallet</h5>
                </div>
                <p>Using this wallet you can operate with your Medic Coin online, solo mining, staking, or create a
                masternode.</p>

                <p>This wallet is for Windows operating system</p>
                </li>
                <li className="mac_section">
                <div className="section_img">
                <img src="images/Maclogo.png"/>
                <h5>Mac Walle</h5>
                </div>
                <p>Using this wallet you can operate with your Medic Coin online, solo mining, staking, or create a 
                masternode.</p>

                <p>This wallet is for Mac</p>
                </li>
                <li className="linux_section">
                <div className="section_img">
                <img src="images/penguin-41066_960_720.png"/>
                <h5>Linux GUI Wallet</h5>
                </div>
                <p>Using this wallet you can operate with your Medic Coin online, solo mining, staking, or create a 
                masternode.</p>

                <p>his wallet is for Linux graphical interface</p>
                </li>
                </ul>
                </div>
            </div>
        </div>

        <div className="main_images_section">
            <div className="inner">
                <div className="images_section">
                    <div className="image_section1">
                        <img src="images/01.jpg"/>
                    </div>
                    <div className="image_section2">
                        <div className="top_img">
                        <img src="images/getty_589583420_293131.jpg"/>
                        </div>
                        <div className="bottom_img">
                        <img src="images/coin_1.jpg"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div className="footer">
            <div className="right_footer inner">
                <div className="sub_right_footer right_head">
                <div className="statistics">
                <a href="index.html"><i className="fa fa-globe" aria-hidden="true"></i>Statistics
                </a>
                </div>
                <div className="master_node">
                <a href="master_node.html"><i className="fa fa-th-list"></i> My  Masternodes</a>
                </div>
                <div className="faq_part">
                <a href="faq_page.html"><i className="fa fa-question-circle"></i> FAQ</a>
                </div>
                </div>
            </div>
            <div className="inner">
            <p>© Copyright 2018 MEDICCION - use of this website is governed by the Terms and conditions of Use</p>
            <div className="social_links">
            <ul>
            <li><i className="fa fa-facebook"></i></li>
            <li><i className="fa fa-twitter"></i></li>
            <li><i className="fa fa-telegram"></i></li>
            </ul>
            </div>
            </div>
        </div>
        </section>
        );
    }
}

if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}
