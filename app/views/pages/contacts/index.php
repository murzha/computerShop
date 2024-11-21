<div class="contacts-page">
    <?php $this->loadComponent('breadcrumbs/breadcrumbs', [
        'items' => [['title' => 'Contact Us']]
    ]); ?>

    <div class="container">
        <div class="contacts-grid">
            <div class="contacts-info">
                <h1 class="contacts-info__title">Contact Us</h1>
                <p class="contacts-info__text">
                    Have questions? We're here to help! Contact us using any of the methods below.
                </p>

                <div class="contact-methods">
                    <div class="contact-method">
                        <i class="bi bi-geo-alt contact-method__icon"></i>
                        <div class="contact-method__content">
                            <h3 class="contact-method__title">Address</h3>
                            <p class="contact-method__text">123 Tech Street, Digital City</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <i class="bi bi-telephone contact-method__icon"></i>
                        <div class="contact-method__content">
                            <h3 class="contact-method__title">Phone</h3>
                            <p class="contact-method__text">+1 234 567 8900</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <i class="bi bi-envelope contact-method__icon"></i>
                        <div class="contact-method__content">
                            <h3 class="contact-method__title">Email</h3>
                            <p class="contact-method__text">support@computer-shop.xyz</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <i class="bi bi-clock contact-method__icon"></i>
                        <div class="contact-method__content">
                            <h3 class="contact-method__title">Working Hours</h3>
                            <p class="contact-method__text">
                                Mon-Fri: 9:00 AM - 8:00 PM<br>
                                Sat: 10:00 AM - 6:00 PM<br>
                                Sun: Closed
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contacts-form">
                <div class="form-wrapper">
                    <h2 class="form-wrapper__title">Send us a message</h2>

                    <form id="contact-form" class="contact-form" method="post" action="/contacts/send">
                        <div class="form-group">
                            <label class="form-label" for="name">Your Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="message">Message</label>
                            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
