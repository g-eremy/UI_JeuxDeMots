<?php
interface
{
	public abstract function filter(int $i, int $count_relations, stdClass $r): bool;
}
