<?php

namespace App\Models;

use App\Models\Base\AclGroup as BaseAclGroup;

class AclGroup extends BaseAclGroup
{
	public function managed_acl_groups()
    {
        return $this->belongsToMany(AclGroup::class, 'acl_group_managed_groups', 'group_id', 'managed_group_id');
    }
}
