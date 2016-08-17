<?php

namespace CMS;

use Doctrine\Dbal\Connection;
use \PDO;

/**
 * A data access class.
 *
 * All data access for tables.
 */
class DbRepository {
	/**
	 * Doctrine Connection object
	 *
	 * @var Connection instance
	 */
	private $conn;

	public function __construct(Connection $conn) {
		$this->conn = $conn;
	}

	public function getAllPages() {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM page');
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Page');

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getSinglePage($pageName) {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM page WHERE pageName=:pageName');
			$stmt->bindParam(':pageName', $pageName);
			$stmt->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Page');
			$stmt->execute();
			if ($result = $stmt->fetch()) {
				return $result;
			} else {
				return;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getPageName($pageRoute) {
		try {
			$stmt = $this->conn->prepare('SELECT pageName FROM page WHERE pageRoute=:pageRoute');
			$stmt->bindParam(':pageRoute', $pageRoute);
			$stmt->execute();
			$result = $stmt->fetchColumn();

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * @param a content id
	 *
	 * @return a bool for success/failure
	 */
	public function showOne($contentId) {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM content WHERE contentId =:contentId');
			$stmt->bindParam(':contentId', $contentId, PDO::PARAM_INT);
			$stmt->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Content');
			$stmt->execute();
			if ($result = $stmt->fetch()) {
				return $result;
			} else {
				return;
			}
		} catch (PDOException $e) {
			echo $e->getMessage;
		}
	}

	/**
	 * gets a pages content.
	 *
	 * @param string $page a page
	 *
	 * @return twig template    template for the page.
	 */
	public function getContent($pageName) {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM content WHERE pageName =:pageName');
			$stmt->bindParam(':pageName', $pageName, PDO::PARAM_STR, 5);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	public function getAllPagesContent() {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM content');
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Content');

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Creates a new web page from the parameters given.
	 *
	 * @param string $pageName     the pagename
	 * @param string $pagePath     the page path/route
	 * @param string $pageTemplate the page template
	 *
	 * @return twig template        the template for the page.
	 */
	public function createPage($pageName, $pageRoute, $pageTemplate) {
		try {
			$pdo = new DbManager();
			$conn = $pdo->getPdoInstance();

			$result = '';

			$stmtpage = $conn->prepare('INSERT IGNORE INTO page(pageId, pageName, pageRoute, pageTemplate, created) VALUES (DEFAULT, :pageName, :pageRoute, :pageTemplate, curdate())');
			$stmttemplate = $conn->prepare('INSERT IGNORE INTO templates(templateid, name, source, last_modified) VALUES (DEFAULT, :name, :source, curdate())');
			# a pdo transaction to execute two queries at the same time.
			# both have to execute without an error for each to work.
			# i.e if theres an error in the second statement, the first statement
			# wont execute either so its both or nothing.
			$conn->beginTransaction();
			$pageName = strtolower($pageName);
			$stmtpage->bindParam(':pageName', $pageName);
			$stmtpage->bindParam(':pageRoute', $pageRoute);
			$stmtpage->bindParam(':pageTemplate', $pageTemplate);
			$stmtpage->execute();

			$pageTemplate = $pageTemplate . '.html.twig';
			$templatecontent = "{% extends 'base.html.twig' %}";
			$stmttemplate->bindParam(':name', $pageTemplate);
			$stmttemplate->bindParam(':source', $templatecontent);
			$stmttemplate->execute();

			if (!$conn->commit()) {
				$result .= 'We have a problem!';
			}

			return $result .= 'Well done! New Page created!';
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Remove a page.
	 *
	 * Also removes a template from the database with the same page name.
	 *
	 * @param string $pageName the page to remove
	 *
	 * @return twig template
	 */
	public function deletePage($pageName, $pageTemplate) {
		try {
			$stmtpage = $this->conn->prepare('DELETE FROM page WHERE pageName =:pageName');
			$stmttemplate = $this->conn->prepare('DELETE FROM templates WHERE name =:pageTemplate');
			$stmtcontent = $this->conn->prepare('DELETE FROM content WHERE pageName=:pageName');
			# begins a transaction for a multiple query
			$this->conn->beginTransaction();
			$stmtpage->bindParam(':pageName', $pageName);
			$stmtpage->execute();

			$template = $pageTemplate . '.html.twig';
			$stmttemplate->bindParam(':pageTemplate', $template);
			$stmttemplate->execute();

			$stmtcontent->bindParam(':pageName', $pageName);
			$stmtcontent->execute();

			$result = '';
			if (!$this->conn->commit()) {
				$result .= 'Heuston we have a problem!';
			}

			return $result .= 'well done. page deleted.';
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function createContent($pageName, $contentType, $contentItemTitle, $contentItem) {
		try {
			$pdo = new DbManager();
			$conn = $pdo->getPdoInstance();
			$result = '';
			$stmt = $conn->prepare('INSERT INTO content(contentId, pageName, contentType, contentItemTitle, contentItem, created) VALUES (DEFAULT, :pagename, :contenttype, :contentitemtitle, :contentitem, curdate())');
			$stmt->bindParam(':pagename', $pageName);
			$stmt->bindParam(':contenttype', $contentType);
			$stmt->bindParam(':contentitemtitle', $contentItemTitle);
			$stmt->bindParam(':contentitem', $contentItem);
			if (!$stmt->execute()) {
				$result .= 'Heuston we have a problem!';
			}

			return $result .= 'Nice. Some new content created';
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function deleteContent($contentId) {
		try {
			$result = '';
			$stmt = $this->conn->prepare('DELETE FROM content WHERE contentId=:contentId');
			$stmt->bindParam(':contentId', $contentId);
			if (!$stmt->execute()) {
				$result .= 'Heuston, we have a problem!';
			}

			return $result .= 'Well done, another post deleted!';
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function editContent($contentId, $pageName, $contentType, $contentItemTitle, $contentItem) {
		try {
			$result = '';
			$stmt = $this->conn->prepare('UPDATE content SET pageName=:pageName, contentType=:contentType, contentItemTitle=:contentItemTitle, contentItem=:contentItem, modified=curdate() WHERE contentId=:contentId');
			$stmt->bindParam(':pageName', $pageName);
			$stmt->bindParam(':contentType', $contentType);
			$stmt->bindParam(':contentItemTitle', $contentItemTitle);
			$stmt->bindParam(':contentItem', $contentItem);
			$stmt->bindParam(':contentId', $contentId);
			if (!$stmt->execute()) {
				return $result .= 'Heuston, We have a problem!';
			}

			return $result .= 'Successfully updated ' . $stmt->rowCount() . ' Items';
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function viewImages() {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM image');
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Image');

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function addImage($imagePath, $contentId) {
		try {
			$stmt = $this->conn->prepare('UPDATE content SET imagePath=:imagePath WHERE contentId=:contentId');
			$stmt->bindParam(':imagePath', $imagePath);
			$stmt->bindParam(':contentId', $contentId);
			$stmt->execute();
			$result = '';
			if ($stmt->rowCount() > 0) {
				$result .= 'Successfully added ' . $stmt->rowCount() . ' Image to some content';
			} else {
				$result .= 'Heuston we have a problemo!';
			}

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function uploadImage($image) {
		try {
			$result = '';
			$stmt = $this->conn->prepare('INSERT IGNORE INTO image(id, contentId, imagePath) VALUES(DEFAULT, DEFAULT, :imagePath)');
			$stmt->bindParam(':imagePath', $image);
			if (!$stmt->execute()) {
				$result .= 'Heuston, we have a problem!';
			} else {
				$result .= 'Great! Successfully uploaded ' . $stmt->rowCount() . ' Image';
			}

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function search($q) {
		try {
			$array = array();
			$stmt = $this->conn->prepare('SELECT * FROM content WHERE contentItemTitle LIKE :q');
			$q = '%' . $q . '%';
			$stmt->bindParam(':q', $q);
			$stmt->execute();

			while ($result = $stmt->fetchAll(PDO::FETCH_OBJ)) {
				$array[] = $result;
			}
			$array = json_encode($array);

			return $array;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}
