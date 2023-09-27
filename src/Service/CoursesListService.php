<?php
namespace App\Service;

use App\Repository\CourseRepository;

class CoursesListService
{
	private $courseRepository;

	public function __construct(CourseRepository $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}
	public function coursesListByDay()
	{
		$courses = $this->courseRepository->findAllOrderByDay();
        $courseList = [];
        foreach ($courses as $course) {
            $hour = $course->getHour()->format('H:i');
            $courseList[$course->getDay()][$hour][] = $course->getName();
        }
		return $courseList;
	}
}
