<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Student\StudentRepositoryInterface;  
use App\Repository\Student\StudentRepository;

use App\Interfaces\Student\StudentpromotionRepositoryInterface;  
use App\Repository\Student\StudentpromotionRepository;

use App\Interfaces\Student\StudentGraduatedRepositoryInterface;  
use App\Repository\Student\StudentGraduatedRepository;

use App\Interfaces\Fees\FeesRepositoryInterface;  
use App\Repository\Fees\FeesRepository;

use App\Interfaces\Fees\FeesTypeRepositoryInterface;  
use App\Repository\Fees\FeesTypeRepository;

use App\Interfaces\Fees\FeeinvoicesRepositoryInterface;  
use App\Repository\Fees\FeeinvoicesRepository;

use App\Interfaces\Student\ReceiptStudentsRepositoryInterface;  
use App\Repository\Student\ReceiptStudentsRepository;

use App\Interfaces\Fees\ProcessingFeeRepositoryInterface;  
use App\Repository\Fees\ProcessingFeeRepository;

use App\Interfaces\Fees\PaymentRepositoryInterface;  
use App\Repository\Fees\PaymentRepository;

use App\Interfaces\Student\AttendanceRepositoryInterface;  
use App\Repository\Student\AttendanceRepository;

use App\Interfaces\Subject\SubjectRepositoryInterface;  
use App\Repository\Subject\SubjectRepository;


use App\Interfaces\Quizzes\QuizzRepositoryInterface;  
use App\Repository\Quizzes\QuizzRepository;

use App\Interfaces\Quizzes\QuestionRepositoryInterface;  
use App\Repository\Quizzes\QuestionRepository;

use App\Repository\TeacherSectionRepository;
use App\Repository\TeacherSectionRepositoryInterface;

use App\Repository\Student\LibraryRepository;
use App\Interfaces\Student\LibraryRepositoryInterface;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StudentpromotionRepositoryInterface::class, StudentpromotionRepository::class);
        $this->app->bind(StudentGraduatedRepositoryInterface::class, StudentGraduatedRepository::class);
        $this->app->bind(FeesRepositoryInterface::class, FeesRepository::class);
        $this->app->bind(FeesTypeRepositoryInterface::class, FeesTypeRepository::class);
        $this->app->bind(FeeinvoicesRepositoryInterface::class, FeeinvoicesRepository::class);
        $this->app->bind(ReceiptStudentsRepositoryInterface::class, ReceiptStudentsRepository::class);
        $this->app->bind(ProcessingFeeRepositoryInterface::class, ProcessingFeeRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(QuizzRepositoryInterface::class, QuizzRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(TeacherSectionRepositoryInterface::class, TeacherSectionRepository::class);
        $this->app->bind(LibraryRepositoryInterface::class, LibraryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
