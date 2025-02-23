<?php
declare (strict_types = 1);
/**
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 *
 * @author Joas Schilling <coding@schilljs.com>
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

namespace OCP\Notification;

/**
 * Interface INotification
 *
 * @package OCP\Notification
 * @since 9.0.0
 */
interface INotification {
	/**
	 * @param string $app
	 * @return $this
	 * @throws \InvalidArgumentException if the app id is invalid
	 * @since 9.0.0
	 */
	public function setApp(string $app);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getApp();

	/**
	 * @param string $user
	 * @return $this
	 * @throws \InvalidArgumentException if the user id is invalid
	 * @since 9.0.0
	 */
	public function setUser(string $user);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getUser();

	/**
	 * @param \DateTime $dateTime
	 * @return $this
	 * @throws \InvalidArgumentException if the $dateTime is invalid
	 * @since 9.0.0
	 */
	public function setDateTime(\DateTime $dateTime);

	/**
	 * @return \DateTime
	 * @since 9.0.0
	 */
	public function getDateTime();

	/**
	 * @param string $type
	 * @param string $id
	 * @return $this
	 * @throws \InvalidArgumentException if the object type or id is invalid
	 * @since 9.0.0
	 */
	public function setObject($type, $id);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getObjectType();

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getObjectId();

	/**
	 * @param string $subject
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the subject or parameters are invalid
	 * @since 9.0.0
	 */
	public function setSubject($subject, array $parameters = []);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getSubject();

	/**
	 * @return string[]
	 * @since 9.0.0
	 */
	public function getSubjectParameters();

	/**
	 * Set a parsed subject
	 *
	 * HTML is not allowed in the parsed subject and will be escaped
	 * automatically by the clients. You can use the RichObjectString system
	 * provided by the Nextcloud server to highlight important parameters via
	 * the setRichSubject method, but make sure, that a plain text message is
	 * always set via setParsedSubject, to support clients which can not handle
	 * rich strings.
	 *
	 * See https://github.com/nextcloud/server/issues/1706 for more information.
	 *
	 * @param string $subject
	 * @return $this
	 * @throws \InvalidArgumentException if the subject is invalid
	 * @since 9.0.0
	 */
	public function setParsedSubject($subject);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getParsedSubject();

	/**
	 * Set a RichObjectString subject
	 *
	 * HTML is not allowed in the rich subject and will be escaped automatically
	 * by the clients, but you can use the RichObjectString system provided by
	 * the Nextcloud server to highlight important parameters.
	 * Also make sure, that a plain text subject is always set via
	 * setParsedSubject, to support clients which can not handle rich strings.
	 *
	 * See https://github.com/nextcloud/server/issues/1706 for more information.
	 *
	 * @param string $subject
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the subject or parameters are invalid
	 * @since 11.0.0
	 */
	public function setRichSubject($subject, array $parameters = []);

	/**
	 * @return string
	 * @since 11.0.0
	 */
	public function getRichSubject();

	/**
	 * @return array[]
	 * @since 11.0.0
	 */
	public function getRichSubjectParameters();

	/**
	 * @param string $message
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the message or parameters are invalid
	 * @since 9.0.0
	 */
	public function setMessage($message, array $parameters = []);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getMessage();

	/**
	 * @return string[]
	 * @since 9.0.0
	 */
	public function getMessageParameters();

	/**
	 * Set a parsed message
	 *
	 * HTML is not allowed in the parsed message and will be escaped
	 * automatically by the clients. You can use the RichObjectString system
	 * provided by the Nextcloud server to highlight important parameters via
	 * the setRichMessage method, but make sure, that a plain text message is
	 * always set via setParsedMessage, to support clients which can not handle
	 * rich strings.
	 *
	 * See https://github.com/nextcloud/server/issues/1706 for more information.
	 *
	 * @param string $message
	 * @return $this
	 * @throws \InvalidArgumentException if the message is invalid
	 * @since 9.0.0
	 */
	public function setParsedMessage($message);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getParsedMessage();

	/**
	 * Set a RichObjectString message
	 *
	 * HTML is not allowed in the rich message and will be escaped automatically
	 * by the clients, but you can use the RichObjectString system provided by
	 * the Nextcloud server to highlight important parameters.
	 * Also make sure, that a plain text message is always set via
	 * setParsedMessage, to support clients which can not handle rich strings.
	 *
	 * See https://github.com/nextcloud/server/issues/1706 for more information.
	 *
	 * @param string $message
	 * @param array $parameters
	 * @return $this
	 * @throws \InvalidArgumentException if the message or parameters are invalid
	 * @since 11.0.0
	 */
	public function setRichMessage($message, array $parameters = []);

	/**
	 * @return string
	 * @since 11.0.0
	 */
	public function getRichMessage();

	/**
	 * @return array[]
	 * @since 11.0.0
	 */
	public function getRichMessageParameters();

	/**
	 * @param string $link
	 * @return $this
	 * @throws \InvalidArgumentException if the link is invalid
	 * @since 9.0.0
	 */
	public function setLink($link);

	/**
	 * @return string
	 * @since 9.0.0
	 */
	public function getLink();

	/**
	 * @param string $icon
	 * @return $this
	 * @throws \InvalidArgumentException if the icon is invalid
	 * @since 11.0.0
	 */
	public function setIcon($icon);

	/**
	 * @return string
	 * @since 11.0.0
	 */
	public function getIcon();

	/**
	 * @return IAction
	 * @since 9.0.0
	 */
	public function createAction();

	/**
	 * @param IAction $action
	 * @return $this
	 * @throws \InvalidArgumentException if the action is invalid
	 * @since 9.0.0
	 */
	public function addAction(IAction $action);

	/**
	 * @return IAction[]
	 * @since 9.0.0
	 */
	public function getActions();

	/**
	 * @param IAction $action
	 * @return $this
	 * @throws \InvalidArgumentException if the action is invalid
	 * @since 9.0.0
	 */
	public function addParsedAction(IAction $action);

	/**
	 * @return IAction[]
	 * @since 9.0.0
	 */
	public function getParsedActions();

	/**
	 * @return bool
	 * @since 9.0.0
	 */
	public function isValid();

	/**
	 * @return bool
	 * @since 9.0.0
	 */
	public function isValidParsed();
}
