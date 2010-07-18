<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This file describes the topic model
 */
 
class Topic extends Model 
{
	function Topic()
	{
		parent::Model();
	}
	
	/**
	* Add a topic entry into the database
	* @exception Throws an exception on failure
	* @return integer Returns the id of the inserted row
	*/
	function add_entry($title, $date_created, $location) 
	{
		$topicData['title'] = $title;
		$topicData['date_created'] = $date_created;
		$topicData['location_id'] = $location_id;
		
		$query = $this->db->insert('topics', $topicData);
		if(!$query) {
			throw new Exception('Failed to add topic entry');
		}
		
		return $this->db->insert_id();
	}
	
	/**
	 * This method sets the topic's content.
	 * If an entry with the given topic exists,
	 * then it will update that entry. Otherwise,
	 * it will create a new entry
	 * @todo No support for revisions yet
	 */
	function set_topic_content($topic, $content, $user)
	{
		$row_data['topic_id'] = $topic;
		$query = $this->db->get_where('topic_contents', $row_data, 1);
		
		// If there is no existing entry
		if($query->num_rows() <= 0) {
			$data['topic_id'] = $topic;
			$data['content'] = $content;
			$data['user_id'] = $user;
			
			$query = $this->db->insert('topic_contents', $data);
			if(!$query) {
				throw new Exception('Unable to insert new topic content');
			}
		
		// We found an existing entry
		} else {
			$data['content'] = $content;
			$data['user_id'] = $id;
			
			$this->db->where('topic_id', $topic);
			$query = $this->db->update('topic_contents', $data);
			
			if(!$query) {
				throw new Exception('Unable to update topic content');
			}
		}
		
		return $query;
	}	
	
}

?>