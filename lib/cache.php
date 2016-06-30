<?php
/* Cache Library */
namespace Instruite\Lib;

class Cache {

  /**
   * Cache Class version
   *
   * @var
   */
  protected $version = '0.2.0';

  /**
   * Default group for cache
   *
   * @string
   */
	public $group = 'instruite';

  /**
   * Default group for cache
   *
   * @string
   */
  public $expiry = 0; //No expiry

  /**
   * Default filler for cache key
   *
   * @string
   */
	public $filler = '-';


   /*
 	* Construct function - sets default paramateres
 	*/
	public function __construct($group = null, $expiry = 0, $filler = null) {
      if ($group) $this->group = $group;
      if ($expiry) $this->expiry = $expiry;
      if ($filler) $this->$filler = $filler;
	}

  /*
	* Build the key for cache
	*/
  public function build_key($parts){
    $cachekey = '';
    $filler = '';
    foreach ($parts as $part){
      $cachekey .= $filler.$part;
      $filler = $this->filler;
    }
    return $cachekey;
  }

	/*
	* Add to cache - use set function instead
	*/
	public function add ($key = null, $data = null, $group = null, $expire = null ){
		if ($key == null) return false;  //Can not do any thing if key is empty
		$group = $this->get_group($group);
    $expire = $this->get_expiry($expire);
		//Add works only if key does not exists
		if ($this->get($key) == false) 	wp_cache_add($key, $data, $group, $expire);
	}

	/*
	* Set cache - add/overwrite
	*/
	public function set ($key = null, $data = null, $group = null, $expire = null ){
		if ($key == null) return false;  //Can not do any thing if key is empty
		$group = $this->get_group($group);
    $expire = $this->get_expiry($expire);
		wp_cache_set($key, $data, $group, $expire);
	}

	/*
	* Get cache
	*/
	public function get ($key = null, $group = null){
		if ($key == null) return false;  //Can not do any thing if key is empty
		$group = $this->get_group($group);
		return wp_cache_get($key, $group, $force = false, $found = null);
	}

	/*
	* Delete cache
	*/
	public function delete ($key = null, $group = null){
		if ($key == null) return false;  //Can not do any thing if key is empty
    $group = $this->get_group($group);
		wp_cache_delete($key, $group);
	}
  //TODO other functions to add
	//wp_cache_replace( $key, $data, $group, $expire )
	//wp_cache_flush()
	//wp_cache_add_non_persistent_groups($groups)

  /*---- Internal Use Functions  ----- */
  /*
  * If group is not provided provieds the default group
  */
  protected function get_group ($group){
     return $group = (is_null($group)) ? $this->group : $group;
  }

  /*
  * If expiry is not provided provieds the default expiry
  */
  protected function get_expiry ($expiry){
     return $expiry = (is_null($expiry)) ? $this->expiry : $expiry;
  }
  /*---- /Internal Use Functions  ----- */

  /*---- TODO - remove unused functions  ----- */

  /**
   *Get Full page cache
   * @param
   *    - Parameters to create the page key $pagetype-$posttype-$postid/$pageno
   *    - @$callback function
   * @return
   *    $pagedata
   * @display
   *    - none
   * @special
   *    - calls the cache builder function in case cache does not exists
   *
   */
    public function get_page_cache($pagetype, $posttype='post', $postid=0, $callback='') {
      //print_r ($callback);
      //$pagedata = call_user_func([$callback['class'], $callback['function']], $callback['args'] );
      //return $pagedata;
      $pagekey = $pagetype.'-'.$posttype.'-'.$postid;
      return $this->get($pagetype.'-'.$posttype.'-'.$postid);
    }
  /*---- /TODO - remove unused functions  ----- */

}

/*
 * -------------------------------------------------------------------------------------
 * V0.0.1
 *    - Initiated class
 * -------------------------------------------------------------------------------------
 * V0.1.0
 *    - Move to Classes from framework
 * -------------------------------------------------------------------------------------
 */
