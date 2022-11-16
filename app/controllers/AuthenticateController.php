<?php

class AuthenticateController extends Controller {
	private $audit;

	public function __construct() {
		parent::__construct();
		$this->audit=\Audit::instance();
	}

	function beforeroute() {

	}

	public function signup() {
		if ($this->f3->exists('SESSION.user')) {
			$this->f3->set('SESSION.error','You are already logged in.');
			$this->f3->reroute('/');
		} else {
			$this->f3->set('title','Register');
			$this->f3->set('content','register.html');
		}
	}

	public function resetPass() {
		if (isset($_POST['reset']) && empty($_POST['hptrap'])) {
			$username=$this->f3->get('POST.email');
			$memword=$this->f3->get('POST.memorableWord');
			$word=$this->f3->get('POST.memword');
			$password=password_hash($this->f3->get('POST.password'),PASSWORD_DEFAULT);
			$this->f3->set('POST.password',$password);

			$this->user->getByName($username);
			$url='http://localhost/simstracker/user/reset/'.$this->user->id;
			//$url = 'https://simstracker.pdasites.uk/user/reset'.$this->user->id;

			if (!$this->user->dry()) {
				if ($word==$memword) {
					$this->user->edit($this->user->id);
					$this->f3->set('SESSION.success',
						'Password changed. You may now log in with your new password.');
					$this->f3->reroute('/');
				} else {
					$this->f3->set('SESSION.error',
						'Memorable word doesn\'t match. Please try again.');
					$this->f3->reroute($url);
				}
			} else {
				$this->f3->set('SESSION.error',
					'Sorry, there was a problem resetting your password.');
				$this->f3->reroute($url);
			}
		} else {
			$userID=$this->f3->get('PARAMS.id');
			$this->user->getById($userID);
			$this->f3->set('user',$this->user);
			$this->f3->set('title','Reset Password');
			$this->f3->set('content','reset.html');
		}
	}

	function authenticate() {
		if (isset($_POST['login'])) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; b; i; br;');
				$username=$this->f3->get('POST.email');
				$password=$this->f3->get('POST.password');
				$login=$this->date;

				$this->user->getByName($username);

				if ($this->user->dry()) {
					$this->f3->set('SESSION.error',
						'Login unsuccessful. Please ensure you have typed your email and password correctly.');
					$this->f3->reroute('/');
				}

				if (password_verify($password,$this->user->password)) {
					$this->user->lastLogin=$login;
					$this->user->save();
					$this->f3->set('SESSION.user',
						array($this->user->name,$this->user->role,$this->user->id,
							$this->user->email));
					$this->f3->reroute('/user/profile');
					if ($_POST["remember"]==1 || $_POST["remember"]=='on' ||
						isset($_POST["remember"])) {
						$hour=time()+3600*24*30;
						setcookie('username',$username,$hour);
						setcookie('password',$password,$hour);
					}
				} else {
					$this->f3->set('SESSION.error',
						'Login unsuccessful. Please ensure you have typed your email and password correctly.');
					$this->f3->reroute('/');
				}
			}
		}
	}

	public function register() {
		if (!empty($_POST['hptrap'])) {
			die('Nice try, Spam-A-Lot');
		} else {
			if ($this->audit->email($this->f3->get('POST.email'),TRUE)) {
				$this->f3->scrub($_POST,'p; b; i; br;');
				$username=$this->f3->get('POST.email');
				$password=password_hash($this->f3->get('POST.password'),PASSWORD_DEFAULT);
				$this->f3->set('POST.password',$password);

				$this->user->getByName($username);

				if ($this->user->dry()) {
					$this->user->add();
					$this->f3->set('SESSION.success',
						'Registration successful. You may now log in.');
				} else {
					$this->f3->set('SESSION.error','User already exists');
				}
			} else {
				$this->f3->set('SESSION.error','Email address is invalid.');
			}
			$this->f3->reroute('/');
		}
	}

	public function logout() {
		$this->f3->clear('SESSION.user');
		$this->f3->set('SESSION.info','You have now logged out.');
		$this->f3->reroute('/');
	}

	public function forgot() {
		if (isset($_POST['send'])) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; b; i; br;');
				if ($this->audit->email($this->f3->get('POST.emailForgot'),TRUE)) {
					$username=$this->f3->get('POST.emailForgot');
					$this->user->getByName($username);

					if ($this->user->dry()) {
						$this->f3->set('SESSION.error','Email address cannot be found.');
						$this->f3->reroute('/');
					} else {
						try {
							$name=$this->user->name;
							$url='http://localhost/simstracker/user/reset/'.
								$this->user->id;
							//$url = 'https://simstracker.pdasites.uk/user/reset'.$this->user->id;
							$this->mail->addAddress($username);     // Add a recipient
							$this->mail->addReplyTo('sammyphoenix79@gmail.com','Admin');
							$this->mail->setFrom($this->f3->get('email_user'),
								$this->f3->get('site'));
							// Content
							$this->mail->isHTML(TRUE);
							$this->mail->Subject='Sims Tracker: Reset password';
							$this->mail->Body=<<<EOT
						<p>Greetings $name,</p>

						<p>You have received this message because someone with your email address has requested a password reset. If this was not you, we advise you to login and change your password immediately.</p>

						<p>If this was you, you can reset your password by clicking the below link:</p>

						<p><a href="$url">Reset my password</a></p>

						<p>Many thanks,</p>

						<p>Sims Tracker Admin</p>
EOT;

							$this->mail->AltBody=<<<EOT
						Greetings $name,

						You have received this message because someone with your email address has requested a password reset. If this was not you, we advise you to login and change your password immediately.

						If this was you, you can reset your password by copying the below link and pasting it into your browser's address bar:

						$url

						Many thanks,

						Sims Tracker Admin
EOT;
							$this->mail->send();
							$this->f3->set('SESSION.success',
								'Thank you, you should receive an email from us soon.');
							$this->f3->reroute('/');
						} catch (Exception $e) {
							$this->f3->set('SESSION.error',
								'Your message could not be sent at this time.');
							$this->f3->reroute('/');
						}
					}
				} else {
					$this->f3->set('SESSION.error','Email address is invalid.');
					$this->f3->reroute('/');
				}
			}
		}
	}
}