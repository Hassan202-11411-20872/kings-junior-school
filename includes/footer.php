<footer class="footer text-white text-center py-3 fixed-bottom shadow animated-footer">
    <div class="footer-wave">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:60px;display:block;">
            <path id="wavePath" d="M0,30 Q360,60 720,30 T1440,30 V60 H0 Z" fill="#1976d2">
                <animate attributeName="d" dur="6s" repeatCount="indefinite"
                    values="M0,30 Q360,60 720,30 T1440,30 V60 H0 Z;
                            M0,30 Q360,0 720,30 T1440,30 V60 H0 Z;
                            M0,30 Q360,60 720,30 T1440,30 V60 H0 Z" />
            </path>
        </svg>
    </div>
    <div class="container">
        <div class="fw-bold" style="font-size:1.1rem;">
            KINGS JUNIOR SCHOOL <br>
            P.O. Box 11413 wakiso | Tel: 0708441411 | 0703460226  GAYAZA MANYANGWA KIWALE <br>
            <span class="footer-motto">"We Hold The Future"</span>
        </div>
        <div class="mt-2" style="font-size:0.95rem;">
            &copy; All rights reserved <?php echo date('Y'); ?> Created by Hassan Mugisha.
        </div>
    </div>
</footer>
</body>
</html>
<style>
.footer {
    font-size: 1.1rem;
    letter-spacing: 1px;
    box-shadow: 0 -4px 24px rgba(25, 118, 210, 0.1);
    border-radius: 0;
    background: #1976d2;
    position: fixed;
    left: 0; right: 0; bottom: 0;
    z-index: 1030;
    padding-top: 0;
    animation: fadeInUpFooter 1.2s cubic-bezier(.39,.575,.56,1.000);
}
.footer-wave {
    position: absolute;
    top: -60px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    z-index: 1;
}
.footer-motto {
    text-shadow: 0 0 8px #fff, 0 0 16px #42a5f5;
    animation: glowMotto 2.5s infinite alternate;
    position: relative;
    z-index: 2;
}
@keyframes fadeInUpFooter {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes glowMotto {
    from { text-shadow: 0 0 8px #fff, 0 0 16px #42a5f5; }
    to { text-shadow: 0 0 16px #fff, 0 0 32px #1976d2; }
}
body { padding-bottom: 90px; }
</style> 