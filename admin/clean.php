<?php
	//何回も実行
	// コンソール実行のこと。
	include('/var/www/twiverse.php');

	try{
		$twitter_admin = twitter_admin();
		mysql_start();
			$collections = twitter_throw($twitter_admin->get('collections/list', ['screen_name' => 'bluehood_admin', count => '200']));
			$coll_ids = [];
			foreach($collections->response->results as $collection){
				$coll_ids []= (int)str_replace('custom-', '', $collection->timeline_id);
			}

			$res = mysql_query("select * from comm");
			while($comm = mysql_fetch_assoc($res)){
				$i = array_search((int)$comm['collection_id'], $coll_ids);
				if ($i !== false){
					unset($coll_ids[$i]);
				}
			}
			
			foreach($coll_ids as $id){
				echo $id.": Delete Collection\n";
				twitter_throw($twitter_admin->post('collections/destroy', ['id' => 'custom-'.$id]));
			}


			$lists = twitter_throw($twitter_admin->get('lists/ownerships', ['screen_name' => 'bluehood_admin', count => '1000']));
			$list_ids = [];
			foreach($lists->lists as $list){
				$list_ids []= (int)$list->id_str;
			}

			$res = mysql_query("select * from comm");
			while($comm = mysql_fetch_assoc($res)){
				$i = array_search((int)$comm['list_id'], $list_ids);
				if ($i !== false){
					unset($list_ids[$i]);
				}
			}
			
			foreach($list_ids as $id){
				echo $id.": Delete List\n";
				twitter_throw($twitter_admin->post('lists/destroy', ['list_id' => $id]));
			}


			/*$res = mysql_query("select * from comm");
			while($comm = mysql_fetch_assoc($res)){
				$collection_id = (int)$comm['collection_id'];
				$twitter_res = $twitter_admin->get('collections/show', ['id' => 'custom-'.$collection_id]);	// not twitter_throw()
				if ($collection_id !== (int)str_replace('custom-', '', $twitter_res->response->timeline_id)){
					echo $collection_id.": Recover Collection\n";
					$collection = $twitter_admin->post('collections/create', ['name' => 'BH'.$comm['name'], 'description' => $comm['name'], url => 'https://bluehood.net/view?comm_id='.$id, timeline_order => 'tweet_reverse_chron']);
					twitter_throw($collection);
					$collection_id = str_replace('custom-', '', $collection->response->timeline_id);
					mysql_query('update comm set collection_id='.$collection_id.' where id="'.$comm['id'].'"');
				}
			}

			$res = mysql_query("select * from comm");
			while($comm = mysql_fetch_assoc($res)){
				$list_id = (int)$comm['list_id'];
				try{
					$twitter_res = twitter_throw($twitter_admin->get('lists/show', ['list_id' => $list_id]));
				}catch(Exception $e){
					echo $list_id.": Recover List\n";
					$list = $twitter_admin->post('lists/create', ['name' => 'BH'.$comm['name'], 'mode' => 'public', 'description' => $comm['name']]);
					twitter_throw($list);
					mysql_query('update comm set list_id='.$list->id.' where id="'.$comm['id'].'"');
				}
				sleep(15);// Rate Limit
			}*/
		mysql_close();
	}catch(Exception $e){
		catch_default($e);
	}
?>
