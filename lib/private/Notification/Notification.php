<?php
declare (strict_types = 1);
/**
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 *
 * @author Joas Schilling <coding@schilljs.com>
 * @author Morris Jobke <hey@morrisjobke.de>
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OC\Notification;


use OCP\Notification\IAction;
use OCP\Notification\INotification;
use OCP\RichObjectStrings\InvalidObjectExeption;
use OCP\RichObjectStrings\IValidator;

class Notification implements INotification {

	/** @var IValidator */
	protected $richValidator;

	/** @var string */
	protected $app;

	/** @var string */
	protected $user;

	/** @var \DateTime */
	protected $dateTime;

	/** @var string */
	protected $objectType;

	/** @var string */
	protected $objectId;

	/** @var string */
	protected $subject;

	/** @var array */
	protected $subjectParameters;

	/** @var string */
	protected $subjectParsed;

	/** @var string */
	protected $subjectRich;

	/** @var array */
	protected $subjectRichParameters;

	/** @var string */
	protected $message;

	/** @var array */
	protected $messageParameters;

	/** @var string */
	protected $messageParsed;

	/** @var string */
	protected $messageRich;

	/** @var array */
	protected $messageRichParameters;

	/** @var string */
	protected $link;

	/** @var string */
	protected $icon;

	/** @var array */
	protected $actions;

	/** @var array */
	protected $actionsParsed;

	/** @var bool */
	protected $hasPrimaryAction;

	/** @var bool */
	protected $hasPrimaryParsedAction;

	/**
	 * Constructor
	 *
	 * @param IValidator $richValidator
	 */
	public function __construct(IValidator $richValidator) {
		$this->richValidator = $richValidator;
		$this->app = '';
		$this->user = '';
		$this->dateTime = new \DateTime();
		$this->dateTime->setTimestamp(0);
		$this->objectType = '';
		$this->objectId = '';
		$this->subject = '';
		$this->subjectParameters = [];
		$this->subjectParsed = '';
		$this->subjectRich = '';
		$this->subjectRichParameters = [];
		$this->message = '';
		$this->messageParameters = [];
		$this->messageParsed = '';
		$this->messageRich = '';
		$this->messageRichParameters = [];
		$this->link = '';
		$this->icon = '';
		$this->actions = [];
		$this->actionsParsed = [];
	}

	/**
	 * @param string $app
	 * @return $this
	 * @throws \InvalidArgumentException if the app id is invalid
	 * @since 8.2.0
	 */
	public function setApp(string $app) {
		if (!is_string($app) || $app === '' || isset($app[32])) {
			throw new \InvalidArgumentException('The given app name is invalid');
		}
		$this->app = $app;
		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 * @param string $user
	 * @return $this
	 * @throws \InvalidArgumentException if the user id is invalid
	 * @since 8.2.0
	 */
	public function setUser(string $user) {
		if (!is_string($user) || $user === '' || isset($user[64])) {
			throw new \InvalidArgumentException('The given user id is invalid');
		}
		$this->user = $user;
		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param \DateTime $dateTime
	 * @return $this
	 * @throws \InvalidArgumentException if the $dateTime is invalid
	 * @since 9.0.0
	 */
	public function setDateTime(\DateTime $dateTime) {
		if ($dateTime->getTimestamp() === 0) {
			throw new \InvalidArgumentException('The given date time is invalid');
		}
		$this->dateTime = $dateTime;
		return $this;
	}

	/**
	 * @return \DateTime
	 * @since 9.0.0
	 */
	public function getDateTime() {
		return $this->dateTime;
	}

	/**
	 * @param string $type
	 * @param string $id
	 * @return $this
	 * @throws \InvalidArgumentException if the object type or id is invalid
	 * @since 8.2.0 - 9.0.0: Type of $id changed to string
	 */
	public function setObject($type, $id) {
		if (!is_string($type) || $type === '' || isset($type[64])) {
			throw new \InvalidArgumentException('The given object type is invalid');
		}
		$this->objectType = $type;

		if (!is_int($id) && (!is_string($id) || $id === '' || isset($id[64]))) {
			throw new \InvalidArgumentException('The given object id is invalid');
		}
		$this->objectId = (string) $id;
		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getObjectType() {
		return $this->objectType;
	}

	/**
	 * @return string
	 * @since 8.2.0 - 9.0.0: Return type changed to string
	 */
	public function getObjectId() {
		return $this->objectId;
	}

	/**
	 * @param string $subject
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the subject or parameters are invalid
	 * @since 8.2.0
	 */
	public function setSubject($subject, array $parameters = []) {
		if (!is_string($subject) || $subject === '' || isset($subject[64])) {
			throw new \InvalidArgumentException('The given subject is invalid');
		}

		$this->subject = $subject;
		$this->subjectParameters = $parameters;

		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @return string[]
	 * @since 8.2.0
	 */
	public function getSubjectParameters() {
		return $this->subjectParameters;
	}

	/**
	 * @param string $subject
	 * @return $this
	 * @throws \InvalidArgumentException if the subject is invalid
	 * @since 8.2.0
	 */
	public function setParsedSubject($subject) {
		if (!is_string($subject) || $subject === '') {
			throw new \InvalidArgumentException('The given parsed subject is invalid');
		}
		$this->subjectParsed = $subject;
		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getParsedSubject() {
		return $this->subjectParsed;
	}

	/**
	 * @param string $subject
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the subject or parameters are invalid
	 * @since 11.0.0
	 */
	public function setRichSubject($subject, array $parameters = []) {
		if (!is_string($subject) || $subject === '') {
			throw new \InvalidArgumentException('The given parsed subject is invalid');
		}

		$this->subjectRich = $subject;
		$this->subjectRichParameters = $parameters;

		return $this;
	}

	/**
	 * @return string
	 * @since 11.0.0
	 */
	public function getRichSubject() {
		return $this->subjectRich;
	}

	/**
	 * @return array[]
	 * @since 11.0.0
	 */
	public function getRichSubjectParameters() {
		return $this->subjectRichParameters;
	}

	/**
	 * @param string $message
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the message or parameters are invalid
	 * @since 8.2.0
	 */
	public function setMessage($message, array $parameters = []) {
		if (!is_string($message) || $message === '' || isset($message[64])) {
			throw new \InvalidArgumentException('The given message is invalid');
		}

		$this->message = $message;
		$this->messageParameters = $parameters;

		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return string[]
	 * @since 8.2.0
	 */
	public function getMessageParameters() {
		return $this->messageParameters;
	}

	/**
	 * @param string $message
	 * @return $this
	 * @throws \InvalidArgumentException if the message is invalid
	 * @since 8.2.0
	 */
	public function setParsedMessage($message) {
		if (!is_string($message) || $message === '') {
			throw new \InvalidArgumentException('The given parsed message is invalid');
		}
		$this->messageParsed = $message;
		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getParsedMessage() {
		return $this->messageParsed;
	}

	/**
	 * @param string $message
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the message or parameters are invalid
	 * @since 11.0.0
	 */
	public function setRichMessage($message, array $parameters = []) {
		if (!is_string($message) || $message === '') {
			throw new \InvalidArgumentException('The given parsed message is invalid');
		}

		$this->messageRich = $message;
		$this->messageRichParameters = $parameters;

		return $this;
	}

	/**
	 * @return string
	 * @since 11.0.0
	 */
	public function getRichMessage() {
		return $this->messageRich;
	}

	/**
	 * @return array[]
	 * @since 11.0.0
	 */
	public function getRichMessageParameters() {
		return $this->messageRichParameters;
	}

	/**
	 * @param string $link
	 * @return $this
	 * @throws \InvalidArgumentException if the link is invalid
	 * @since 8.2.0
	 */
	public function setLink($link) {
		if (!is_string($link) || $link === '' || isset($link[4000])) {
			throw new \InvalidArgumentException('The given link is invalid');
		}
		$this->link = $link;
		return $this;
	}

	/**
	 * @return string
	 * @since 8.2.0
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * @param string $icon
	 * @return $this
	 * @throws \InvalidArgumentException if the icon is invalid
	 * @since 11.0.0
	 */
	public function setIcon($icon) {
		if (!is_string($icon) || $icon === '' || isset($icon[4000])) {
			throw new \InvalidArgumentException('The given icon is invalid');
		}
		$this->icon = $icon;
		return $this;
	}

	/**
	 * @return string
	 * @since 11.0.0
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @return IAction
	 * @since 8.2.0
	 */
	public function createAction() {
		return new Action();
	}

	/**
	 * @param IAction $action
	 * @return $this
	 * @throws \InvalidArgumentException if the action is invalid
	 * @since 8.2.0
	 */
	public function addAction(IAction $action) {
		if (!$action->isValid()) {
			throw new \InvalidArgumentException('The given action is invalid');
		}

		if ($action->isPrimary()) {
			if ($this->hasPrimaryAction) {
				throw new \InvalidArgumentException('The notification already has a primary action');
			}

			$this->hasPrimaryAction = true;
		}

		$this->actions[] = $action;
		return $this;
	}

	/**
	 * @return IAction[]
	 * @since 8.2.0
	 */
	public function getActions() {
		return $this->actions;
	}

	/**
	 * @param IAction $action
	 * @return $this
	 * @throws \InvalidArgumentException if the action is invalid
	 * @since 8.2.0
	 */
	public function addParsedAction(IAction $action) {
		if (!$action->isValidParsed()) {
			throw new \InvalidArgumentException('The given parsed action is invalid');
		}

		if ($action->isPrimary()) {
			if ($this->hasPrimaryParsedAction) {
				throw new \InvalidArgumentException('The notification already has a primary action');
			}

			$this->hasPrimaryParsedAction = true;

			// Make sure the primary action is always the first one
			array_unshift($this->actionsParsed, $action);
		} else {
			$this->actionsParsed[] = $action;
		}

		return $this;
	}

	/**
	 * @return IAction[]
	 * @since 8.2.0
	 */
	public function getParsedActions() {
		return $this->actionsParsed;
	}

	/**
	 * @return bool
	 * @since 8.2.0
	 */
	public function isValid() {
		return
			$this->isValidCommon()
			&&
			$this->getSubject() !== ''
		;
	}

	/**
	 * @return bool
	 * @since 8.2.0
	 */
	public function isValidParsed() {
		if ($this->getRichSubject() !== '' || !empty($this->getRichSubjectParameters())) {
			try {
				$this->richValidator->validate($this->getRichSubject(), $this->getRichSubjectParameters());
			} catch (InvalidObjectExeption $e) {
				return false;
			}
		}

		if ($this->getRichMessage() !== '' || !empty($this->getRichMessageParameters())) {
			try {
				$this->richValidator->validate($this->getRichMessage(), $this->getRichMessageParameters());
			} catch (InvalidObjectExeption $e) {
				return false;
			}
		}

		return
			$this->isValidCommon()
			&&
			$this->getParsedSubject() !== ''
		;
	}

	/**
	 * @return bool
	 */
	protected function isValidCommon() {
		return
			$this->getApp() !== ''
			&&
			$this->getUser() !== ''
			&&
			$this->getDateTime()->getTimestamp() !== 0
			&&
			$this->getObjectType() !== ''
			&&
			$this->getObjectId() !== ''
		;
	}
}
