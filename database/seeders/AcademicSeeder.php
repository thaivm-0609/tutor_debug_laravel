<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicSeeder extends Seeder
{
    /**
     * Seed majors, subjects, and 100 tests.
     */
    public function run(): void
    {
        $now = now();

        $majors = [
            ['code' => 'CNTT', 'name' => 'Công nghệ thông tin', 'description' => 'Đào tạo kỹ sư phát triển và vận hành hệ thống phần mềm.'],
            ['code' => 'KHMT', 'name' => 'Khoa học máy tính', 'description' => 'Đào tạo nền tảng thuật toán, trí tuệ nhân tạo và tính toán.'],
            ['code' => 'KTPM', 'name' => 'Kỹ thuật phần mềm', 'description' => 'Đào tạo quy trình phân tích, thiết kế và kiểm thử phần mềm.'],
            ['code' => 'HTTT', 'name' => 'Hệ thống thông tin', 'description' => 'Đào tạo phân tích nghiệp vụ và xây dựng hệ thống thông tin.'],
            ['code' => 'ATTT', 'name' => 'An toàn thông tin', 'description' => 'Đào tạo bảo mật hệ thống, mạng và dữ liệu.'],
        ];

        DB::table('majors')->insert(array_map(
            fn (array $major) => $major + ['created_at' => $now, 'updated_at' => $now],
            $majors
        ));

        $majorIds = DB::table('majors')->pluck('id', 'code');

        $subjectsByMajor = [
            'CNTT' => [
                ['code' => 'CNTT101', 'name' => 'Nhập môn lập trình', 'credits' => 3],
                ['code' => 'CNTT102', 'name' => 'Cấu trúc dữ liệu và giải thuật', 'credits' => 4],
                ['code' => 'CNTT201', 'name' => 'Cơ sở dữ liệu', 'credits' => 3],
                ['code' => 'CNTT202', 'name' => 'Mạng máy tính', 'credits' => 3],
            ],
            'KHMT' => [
                ['code' => 'KHMT101', 'name' => 'Toán rời rạc', 'credits' => 3],
                ['code' => 'KHMT102', 'name' => 'Cấu trúc máy tính', 'credits' => 3],
                ['code' => 'KHMT201', 'name' => 'Trí tuệ nhân tạo', 'credits' => 3],
                ['code' => 'KHMT202', 'name' => 'Học máy', 'credits' => 4],
            ],
            'KTPM' => [
                ['code' => 'KTPM101', 'name' => 'Phân tích yêu cầu phần mềm', 'credits' => 3],
                ['code' => 'KTPM102', 'name' => 'Thiết kế hướng đối tượng', 'credits' => 3],
                ['code' => 'KTPM201', 'name' => 'Kiểm thử phần mềm', 'credits' => 3],
                ['code' => 'KTPM202', 'name' => 'Quản lý dự án phần mềm', 'credits' => 2],
            ],
            'HTTT' => [
                ['code' => 'HTTT101', 'name' => 'Nhập môn hệ thống thông tin', 'credits' => 3],
                ['code' => 'HTTT102', 'name' => 'Phân tích thiết kế hệ thống', 'credits' => 3],
                ['code' => 'HTTT201', 'name' => 'Kho dữ liệu', 'credits' => 3],
                ['code' => 'HTTT202', 'name' => 'Thương mại điện tử', 'credits' => 2],
            ],
            'ATTT' => [
                ['code' => 'ATTT101', 'name' => 'Nhập môn an toàn thông tin', 'credits' => 3],
                ['code' => 'ATTT102', 'name' => 'Mật mã học', 'credits' => 3],
                ['code' => 'ATTT201', 'name' => 'An ninh mạng', 'credits' => 3],
                ['code' => 'ATTT202', 'name' => 'Điều tra số', 'credits' => 3],
            ],
        ];

        $subjects = [];

        foreach ($subjectsByMajor as $majorCode => $majorSubjects) {
            foreach ($majorSubjects as $subject) {
                $subjects[] = $subject + [
                    'major_id' => $majorIds[$majorCode],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('subjects')->insert($subjects);

        $subjectIds = DB::table('subjects')->orderBy('id')->pluck('id');
        $types = ['quiz', 'midterm', 'final', 'practice'];
        $durations = [45, 60, 90, 120];
        $tests = [];

        for ($i = 1; $i <= 100; $i++) {
            $tests[] = [
                'subject_id' => $subjectIds[($i - 1) % $subjectIds->count()],
                'name' => sprintf('Bài kiểm tra %02d', $i),
                'type' => $types[($i - 1) % count($types)],
                'duration_minutes' => $durations[($i - 1) % count($durations)],
                'max_score' => 10,
                'tested_at' => $now->copy()->subDays(100 - $i)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tests')->insert($tests);
    }
};
