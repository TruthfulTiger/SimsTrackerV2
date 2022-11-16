<?php

class ContactController extends Controller {
	private $user;
	private $audit;

	public function __construct() {
		parent::__construct();
		$this->user=new User($this->db);
		$this->audit=\Audit::instance();
	}

	function beforeroute() {

	}

	function index() {
		$this->user->getById($this->f3->get('SESSION.user[2]'));
		$this->f3->set('user',$this->user);
		$this->f3->set('content','contact.html');
		$this->f3->set('title','Contact');

		if (isset($_POST['send'])) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				try {
					$this->f3->scrub($_POST,'p; b; i; br;');
					if ($this->audit->email($this->f3->get('POST.email'),TRUE)) {
						$this->mail->addAddress('sammyphoenix79@gmail.com',
							'Admin');     // Add a recipient
						$this->mail->addReplyTo($this->f3->get('POST.email'),
							$this->f3->get('POST.name'));
						$this->mail->setFrom($this->f3->get('email_user'),
							$this->f3->get('site'));

						// Content
						$this->mail->isHTML(TRUE);
						$this->mail->Subject=
							'Contact form: '.$this->f3->get('POST.subject');
						$this->mail->Body=
							<<<EOT
						<p><b>Email:</b> {$this->f3->get('POST.email')}</p>
						<p><b>Name:</b> {$this->f3->get('POST.name')}</p>
						<p>{$this->f3->get('POST.message')}</p>
EOT;
						$this->mail->AltBody=
							<<<EOT
						Email: {$this->f3->get('POST.email')}
						Name: {$this->f3->get('POST.name')}
						Message: {$this->f3->get('POST.message')}
EOT;

						$this->mail->send();
						$this->f3->set('SESSION.success',
							'Thank you, your message has been sent.');
					} else {
						$this->f3->set('SESSION.error','Email address is invalid.');
					}
				} catch (Exception $e) {
					$this->f3->set('SESSION.error',
						'Your message could not be sent at this time.');
				}
			}
		}
	}
}
