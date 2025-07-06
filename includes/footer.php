<!-- Bubble Footer Start -->
<div class="footer-container">
    <div class="wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,20 C200,60 400,-10 600,40 C800,90 1000,20 1200,50 L1200,120 L0,120 Z" fill="#0a58ca"></path>
        </svg>
    </div>
    <!-- Water Bubbles -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <footer class="footer">
        <p class="school-name">KING'S JUNIOR SCHOOL</p>
        <p class="contact-info">P.O. Box 11413 Wakiso | Tel: 0708441411 | 0703460226</p>
        <p class="contact-info">GAYAZA MANYANGWA KIWALE</p>
        <p class="slogan">"We Hold The Future"</p>
        <p class="copyright">© All rights reserved 2025 | Created by Hassan Mugisha</p>
    </footer>
</div>
<style>
.footer-container {
    position: relative;
    margin-top: auto;
    overflow: hidden;
    width: 100%;
}
.wave {
    position: absolute;
    top: -25px;
    left: 0;
    width: 100%;
    height: 80px;
    overflow: hidden;
}
.wave svg {
    width: 200%;
    height: 100%;
    animation: wave 7s linear infinite;
}
.bubble {
    position: absolute;
    background-color: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    filter: blur(1px);
    animation: bubble-rise calc(4s * 0.56) linear infinite;
    z-index: 2;
}
.bubble:nth-child(2) { left: 10%; width: 8px; height: 8px; animation-delay: 0s; }
.bubble:nth-child(3) { left: 25%; width: 12px; height: 12px; animation-delay: 0.5s; }
.bubble:nth-child(4) { left: 40%; width: 6px; height: 6px; animation-delay: 1s; }
.bubble:nth-child(5) { left: 55%; width: 10px; height: 10px; animation-delay: 1.5s; }
.bubble:nth-child(6) { left: 70%; width: 14px; height: 14px; animation-delay: 2s; }
.bubble:nth-child(7) { left: 85%; width: 7px; height: 7px; animation-delay: 2.5s; }
.footer {
    background: linear-gradient(135deg, #0a58ca 0%, #0d6efd 100%);
    color: white;
    padding: 60px 20px 25px;
    text-align: center;
    position: relative;
    z-index: 3;
    width: 100%;
    /* Optional: add a semi-transparent overlay for extra contrast */
    /* background: rgba(10, 88, 202, 0.95); */
}
.school-name {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 10px !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}
.contact-info {
    font-size: 14px;
}
.slogan {
    font-style: italic;
    margin: 15px 0 !important;
    font-weight: 500;
    color: white;
    display: inline-block;
    animation: glow-pulse 1.4s ease-in-out infinite alternate, text-wave 2s ease-in-out infinite;
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.7);
}
.copyright {
    font-size: 12px;
    opacity: 0.9;
    margin-top: 20px !important;
}
@keyframes wave {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes bubble-rise {
    0% { transform: translateY(100px) scale(0.8); opacity: 0; }
    20% { opacity: 0.6; }
    100% { transform: translateY(-80px) scale(1.2); opacity: 0; }
}
@keyframes glow-pulse {
    0% { text-shadow: 0 0 8px rgba(255, 255, 255, 0.7); color: white; }
    100% { text-shadow: 0 0 16px rgba(255, 255, 255, 0.9), 0 0 24px rgba(255, 255, 255, 0.6); color: #ffffff; }
}
@keyframes text-wave {
    0%, 100% { transform: translateY(0) rotate(-1.5deg); }
    25% { transform: translateY(-3px) rotate(0deg); }
    50% { transform: translateY(0) rotate(1.5deg); }
    75% { transform: translateY(-2px) rotate(0deg); }
}
@media (max-width: 768px) {
    .footer { padding: 50px 15px 20px; }
    .slogan { font-size: 16px; }
    .bubble { animation-duration: calc(3s * 0.56); }
}
</style>
<!-- Bubble Footer End -->
