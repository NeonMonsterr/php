<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BIO MARAKBY</title>
    <meta name="description"
        content=" بفضل الخبرة الطويلة، ساعدنا مئات الطلاب على تحسين مستواهم الدراسي
                    وتحقيق أعلى الدرجات في المواد العلمية." />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link rel="icon" href="images/logo.png" type="image/x-icon" />
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="{{ route('welcome') }}" class="logo" data-aos="fade-down"><img style="width: 6rem;"
                    src="images/logo.png" alt=""></a>
            <nav class="navbar" data-aos="fade-down">
                <ul>
                    <li><a href="{{ route('welcome') }}" class="active">الرئيسية</a></li>
                    <li><a href="#about">من نحن</a></li>
                    <li><a href="#lessons">الدروس</a></li>
                    <li><a href="#testimonials">اراء الطلاب</a></li>
                    <li><a href="#contact">تواصل معنا</a></li>
                    <li class="mobile-login">
                        <a href="{{ route('login') }}" class="login-button">
                            <img src="{{ asset('images/dna.gif') }}" alt="DNA Icon" loading="lazy"
                                style="width: 40px; height: 40px; margin-left:6px;">
                            <span class="text">تسجيل الدخول</span>
                        </a>
                    </li>
                    <li class="mobile-login">
                        <a href="{{ route('register.form') }}" class="login-button">
                            <img src="{{ asset('images/dna.gif') }}" alt="DNA Icon" loading="lazy"
                                style="width: 40px; height: 40px; margin-left:6px;">
                            <span class="text">إنشاء حساب</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div style="display: flex">
                <a style="font-size: medium;" href="{{ route('login') }}" class="login-button desktop-only">
                    <span class="text">
                        <img src="{{ asset('images/dna.gif') }}" alt="DNA Icon" loading="lazy"
                            style="width: 40px; height: 40px; margin-left: 6px;">
                        تسجيل الدخول
                    </span>
                </a>
                <a style="font-size: medium; margin-right: 1rem" href="{{ route('register.form') }}" class="login-button desktop-only">
                    <span class="text">
                        <img src="{{ asset('images/dna.gif') }}" alt="DNA Icon" loading="lazy"
                            style="width: 40px; height: 40px; margin-left: 6px;">
                        إنشاء حساب
                    </span>
                </a>
            </div>
            <button class="menu-toggle" aria-label="قائمة الهاتف">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content" data-aos="fade-right">
                <h1>اهلا بكم انا,<span class="highlight">م/ محمد </span></h1>
                <h2>مدرس علوم و احياء</h2>
                <p class="hero-description">
                    بفضل الخبرة الطويلة، ساعدنا مئات الطلاب على تحسين مستواهم الدراسي
                    وتحقيق أعلى الدرجات في المواد العلمية.
                </p>
                <div class="hero-buttons">
                    <a href="#contact" class="btn btn-outline">تواصل معنا</a>
                </div>
                <div class="social-links">
                    <a href="https://www.facebook.com/mrmohamed10?mibextid=rS40aB7S9Ucbxw6v" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://wa.me/201090474881?text=مرحبًا%20أستاذ%20محمد،%20أرغب%20في%20الاستفسار%20عن%20الدروس."
                        target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <img class="profile-image pulse" src="images/profile.png" loading="lazy" alt="أحمد الجوهري" />
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="about-section" id="about">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">من نحن</h2>
            <div class="about-grid">
                <div class="about-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="about-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>خبرة تعليمية</h3>
                    <p>
                        يمتلك أستاذ محمد خبرة تفوق 10 سنوات في تدريس العلوم والأحياء، ساعد
                        خلالها العديد من الطلاب على تحقيق التميز الأكاديمي.
                    </p>
                </div>
                <div class="about-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="about-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h3>شرح مبسط وتطبيقي</h3>
                    <p>
                        نحرص على تقديم المعلومات بأسلوب سهل ومبسط، مع ربط الدروس بالتجارب
                        والواقع العلمي لتحفيز الفهم العميق.
                    </p>
                </div>
                <div class="about-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="about-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>متابعة شخصية</h3>
                    <p>
                        يتم متابعة الطلاب بشكل فردي وتقديم الدعم المستمر لضمان تقدمهم
                        واستيعابهم للمحتوى الدراسي.
                    </p>
                </div>
                <div class="about-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="about-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>منصة biomarakby</h3>
                    <p>
                        منصتنا الإلكترونية توفر محتوى تفاعليًا وشروحات مسجلة، لتسهيل
                        التعلم في أي وقت ومن أي مكان.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Preview -->
    <section class="lessons-preview" id="lessons">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">الدروس</h2>
            <div class="lessons-grid">
                <!-- درس 1 -->
                <div class="lesson-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="lesson-image">
                        <img src="images/3.png" loading="lazy" alt="درس 1" />
                        <div class="lesson-overlay">
                            <h3 style="color: white;">التكاثر في الإنسان</h3>
                            <a style="color:cadetblue;" href="{{ route('login') }}" class="btn btn-small">مشاهدة
                                الدرس</a>
                        </div>
                    </div>
                    <div class="lesson-info">
                        <h3>درس التكاثر</h3>
                        <div class="lesson-meta">
                            <span>الأحياء - الصف الثالث الثانوي</span>
                            <span>مدة الدرس: 20 دقيقة</span>
                        </div>
                    </div>
                </div>

                <!-- درس 2 -->
                <div class="lesson-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="lesson-image">
                        <img src="images/1.png" loading="lazy" alt="درس 2" />
                        <div class="lesson-overlay">
                            <h3 style="color: white;">التركيب الذري</h3>
                            <a style="color:cadetblue;" href="{{ route('login') }}" class="btn btn-small">مشاهدة
                                الدرس</a>
                        </div>
                    </div>
                    <div class="lesson-info">
                        <h3>درس الذرات</h3>
                        <div class="lesson-meta">
                            <span>العلوم - الصف الثاني الإعدادي</span>
                            <span>مدة الدرس: 15 دقيقة</span>
                        </div>
                    </div>
                </div>

                <!-- درس 3 -->
                <div class="lesson-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="lesson-image">
                        <img src="images/2.png" loading="lazy" alt="درس 3" />
                        <div class="lesson-overlay">
                            <h3 style="color: white;">الجهاز العصبي</h3>
                            <a style="color:cadetblue;" href="{{ route('login') }}" class="btn btn-small">مشاهدة
                                الدرس</a>
                        </div>
                    </div>
                    <div class="lesson-info">
                        <h3>درس الجهاز العصبي</h3>
                        <div class="lesson-meta">
                            <span>الأحياء - الصف الثاني الثانوي</span>
                            <span>مدة الدرس: 18 دقيقة</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center" data-aos="fade-up" style="margin-top: 1rem">
                <a href="{{ route('login') }}" class="btn btn-outline">عرض جميع الدروس</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">آراء الطلاب</h2>
            <div class="testimonial-slider">
                <!-- رأي 1 -->
                <div class="testimonial active" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-content">
                        <p>
                            "الشرح بسيط وسهل، وأسلوب مستر محمد ممتع جدًا، فهمت الدرس لأول
                            مرة بدون تعب."
                        </p>
                        <div class="client-info">
                            <img src="images/1.jpg" loading="lazy" alt="أحمد محمود" />
                            <div>
                                <h4>أحمد محمود</h4>
                                <span>طالب ثانوية عامة</span>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رأي 2 -->
                <div class="testimonial" data-aos="fade-up" data-aos-delay="150">
                    <div class="testimonial-content">
                        <p>
                            "مستر محمد بيشرح بطريقة منظمة جدًا، والمنصة سهلت عليا أذاكر في
                            أي وقت."
                        </p>
                        <div class="client-info">
                            <img src="images/3.jpg" loading="lazy" alt="مي عبد الله" />
                            <div>
                                <h4>مي عبد الله</h4>
                                <span>طالبة - الصف الثاني الثانوي</span>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رأي 3 -->
                <div class="testimonial" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-content">
                        <p>
                            "أكتر حاجة عجبتني إن مستر محمد بيهتم يفهمنا مش بس يحفظنا، شكراً
                            ليه."
                        </p>
                        <div class="client-info">
                            <img src="images/2.jpg" loading="lazy" alt="كريم حسن" />
                            <div>
                                <h4>كريم حسن</h4>
                                <span>طالب - الصف الأول الثانوي</span>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رأي 4 -->
                <div class="testimonial" data-aos="fade-up" data-aos-delay="250">
                    <div class="testimonial-content">
                        <p>
                            "أفضل أستاذ أحياء اتعلمت منه، بيشرح بالتفصيل وبيركز على النقاط
                            المهمة جدًا."
                        </p>
                        <div class="client-info">
                            <img src="images/5.jpg" loading="lazy" alt="ندى أحمد" />
                            <div>
                                <h4>ندى أحمد</h4>
                                <span>طالبة - الصف الثالث الثانوي</span>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رأي 5 -->
                <div class="testimonial" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-content">
                        <p>
                            "المنصة فيها كل حاجة بحتاجها، والفيديوهات قصيرة ومركزة، برافو
                            مستر محمد."
                        </p>
                        <div class="client-info">
                            <img src="images/4.jpg" loading="lazy" alt="علي جمال" />
                            <div>
                                <h4>علي جمال</h4>
                                <span>طالب - الصف الثالث الإعدادي</span>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رأي 6 -->
                <div class="testimonial" data-aos="fade-up" data-aos-delay="350">
                    <div class="testimonial-content">
                        <p>
                            "بجد شرح ممتاز ومتابعة شخصية، خلاني أحب مادة الأحياء بعد ما كنت
                            بكرهها."
                        </p>
                        <div class="client-info">
                            <img src="images/3.jpg" loading="lazy" alt="إسراء محمد" />
                            <div>
                                <h4>إسراء محمد</h4>
                                <span>طالبة - المرحلة الثانوية</span>
                                <div class="stars">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="slider-controls">
                    <button class="slider-prev">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="slider-next">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Preview -->
    <section class="blog-preview" id="blog">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">أحدث المقالات</h2>
            <div class="blog-grid">
                <!-- مقال 1: الصف الأول الإعدادي -->
                <div class="blog-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="blog-image">
                        <img src="images/p1.gif" loading="lazy" alt="الصف الأول الإعدادي" />
                        <div class="blog-date">20 يونيو 2025</div>
                    </div>
                    <div class="blog-content">
                        <h3>
                            <a>كيف تبدأ مذاكرة العلوم للصف الأول الإعدادي؟</a>
                        </h3>
                        <p>
                            خطوات بسيطة تساعدك على فهم دروس العلوم بسهولة، وطريقة تنظيم
                            الوقت بين المذاكرة وحل الأسئلة.
                        </p>
                    </div>
                </div>

                <!-- مقال 2: الصف الثالث الإعدادي -->
                <div class="blog-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="blog-image">
                        <img src="images/p2.gif" loading="lazy" alt="الصف الثالث الإعدادي" />
                        <div class="blog-date">18 يونيو 2025</div>
                    </div>
                    <div class="blog-content">
                        <h3>
                            <a>أهم الأسئلة المتوقعة في العلوم للصف الثالث الإعدادي</a>
                        </h3>
                        <p>
                            تعرف على أهم النقاط والأسئلة التي يجب التركيز عليها قبل امتحانات
                            العلوم النهائية لهذا العام.
                        </p>
                    </div>
                </div>

                <!-- مقال 3: الصف الثالث الثانوي -->
                <div class="blog-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="blog-image">
                        <img src="images/p3.gif" loading="lazy" alt="الصف الثالث الثانوي" />
                        <div class="blog-date">15 يونيو 2025</div>
                    </div>
                    <div class="blog-content">
                        <h3>
                            <a>أفضل طرق مراجعة الأحياء للثانوية العامة</a>
                        </h3>
                        <p>
                            نصائح فعالة لمذاكرة ومراجعة مادة الأحياء بطريقة ذكية تضمن لك
                            التميز والتفوق في الثانوية العامة.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2>لو مشتت لحد دلوقتى ومش عارف تاخد خطوة</h2>
                <p>
                    احب اقولك ان كل الاوائل كدة بيكونوا خايفين بس لما بياخدوا الخطوة
                    بيكتشفوا بعدين عقولهم
                </p>
                <a href="{{ route('login') }}" class="btn btn-outline">يلا بينا سوا</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about" data-aos="fade-up">
                    <a href="index.html" class="footer-logo">BioMarakby</a>
                    <p>
                        ساعدنا مئات الطلاب على تحسين مستواهم الدراسي وتحقيق أعلى الدرجات
                        في المواد العلمية.
                    </p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/mrmohamed10?mibextid=rS40aB7S9Ucbxw6v" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://wa.me/201090474881?text=مرحبًا%20أستاذ%20محمد،%20أرغب%20في%20الاستفسار%20عن%20الدروس."
                            target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                <div class="footer-links" data-aos="fade-up" data-aos-delay="100">
                    <h3>روابط سريعة</h3>
                    <ul>
                        <li><a href="{{ route('welcome') }}">الرئيسية</a></li>
                        <li><a href="#about">عني</a></li>
                        <li><a href="#lessons">الدروس</a></li>
                        <li><a href="#blog">المدونة</a></li>
                        <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
                    </ul>
                </div>
                <div class="footer-contact" data-aos="fade-up" data-aos-delay="200">
                    <h3>تواصل معي</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i>ahmed@biomarakby.com</li>
                        <li><i class="fas fa-phone"></i>01090474881</li>
                        <li><i class="fas fa-map-marker-alt"></i> القاهرة، مصر</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom" style="justify-content: center">
                <div class="copyright">
                    &copy; تم تطوير المنصة من شركة
                    <a style="color: violet" href="https://www.softcodedevelop.com/" target="_blank">SoftCode</a>.
                    جميع الحقوق محفوظة 2025
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" aria-label="العودة للأعلى">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript Files -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const testimonials = document.querySelectorAll('.testimonial');
            const nextBtn = document.querySelector('.slider-next');
            const prevBtn = document.querySelector('.slider-prev');

            let currentIndex = 0;

            function showTestimonial(index) {
                testimonials.forEach((testimonial, i) => {
                    testimonial.classList.remove('active');
                    testimonial.style.display = 'none';
                    if (i === index) {
                        testimonial.classList.add('active');
                        testimonial.style.display = 'block';
                    }
                });
            }

            function showNext() {
                currentIndex = (currentIndex + 1) % testimonials.length;
                showTestimonial(currentIndex);
            }

            function showPrev() {
                currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
                showTestimonial(currentIndex);
            }

            // Event listeners
            nextBtn.addEventListener('click', showNext);
            prevBtn.addEventListener('click', showPrev);

            // Initialize first testimonial
            showTestimonial(currentIndex);
        });
    </script>
</body>

</html>
