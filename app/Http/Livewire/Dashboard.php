<?php

namespace App\Http\Livewire;
use Livewire\Component;

class Dashboard extends Component
{
    public $currentTime;
    public $currentDate;
    public $days;
    public $hours;
    public $minutes;
    public $seconds;
    public $serverIp;
    public $serverStartTime;
    public $diskTotal;
    public $diskFree;
    public $diskUsed;
    public $diskUsedPercentage;
    public $totalMemory;
    public $freeMemory;
    public $usedMemory;
    public $memoryUsagePercentage;
    public $hostname;
    public $operatingSystem;
    public $webServer;
    public $cpuInfo;
    public $serverUrl;
    public $services = [];
    public $cpuModel ='';

    public function mount()
    {
        // Initialize with current time including seconds
        $this->currentTime = now()->format('H:i:s');
        //Get current date
        $this->currentDate = now()->format('l, F j, Y');


        // Fetch the server start time
        $this->serverStartTime = $this->getServerStartTime();

        // Set initial values to uptime
        $this->updateUptime();
        $this->startTimer(); // Start updating time every seconds

        // Fetch the server IP address
        $this->serverIp = request()->server('SERVER_ADDR');
        $this->serverIp = $this->serverIp === null ? '3.15.254.99': $this->serverIp;

        // Fetch the server URL
        $this->serverUrl = $this->getServerUrl();

        // Fetch the disk space information
        $this->getDiskSpace();

        // Fetch the memory usage information
        $this->getMemoryUsage();

        // Fetch server information
        $this->hostname = gethostname();
        $this->operatingSystem = PHP_OS;
        $this->webServer = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
        $this->cpuInfo = $this->getCpuInfo();

        // Fetch service status
        $this->getAllServicesStatus();
    }

    public function getAllServicesStatus()
    {
        if(PHP_OS_FAMILY === 'Linux'){
            // Define the specific services you want to check
            $servicesToCheck = ['apache2.service', 'mysql.service', 'zabbix-agent.service'];

            // Execute systemctl command to get detailed service information
            $command = 'systemctl list-units --type=service --all --no-pager --output=short';
            $serviceList = shell_exec($command);

            if ($serviceList) {
                $lines = explode("\n", trim($serviceList));
                $services = [];

                // Skip the header line
                array_shift($lines);

                foreach ($lines as $line) {
                    // Split the line into columns
                    $parts = preg_split('/\s+/', $line, 6);

                    // Check if the line has enough parts
                    if (count($parts) >= 5 && in_array($parts[1], $servicesToCheck)) {
                        $services[] = [
                            'unit'          => $parts[1],  // Service name
                            'load_state'    => $parts[2],  // Load state
                            'active_state'  => $parts[3],  // Active state
                            'sub_state'     => $parts[4],  // Sub state
                            'description'   => $parts[5],  // Description
                        ];
                    }
                }

                $this->services = $services;
            }
        }else{
            $this->services = [];

        }
    }

    public function getServerUrl()
    {
        return url('/');
    }

    public function getCpuInfo()
    {
        $cpuInfo = 'Unknown';

        if (PHP_OS_FAMILY === 'Linux') {
            // For Linux systems
            $cpuInfo = shell_exec('lscpu');

            if ($cpuInfo) {
                // Find the line that starts with "Model name" and extract it
                preg_match('/Model name:\s*(.*?)\s+CPU family:/s', $cpuInfo, $matches);

                if (isset($matches[1])) {
                    $this->cpuModel = trim($matches[1]);
                } else {
                    $this->cpuModel = 'Unknown CPU Model';
                }
            } else {
                $this->cpuModel = 'Unable to retrieve CPU information';
            }
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            // For macOS systems
            $this->cpuModel = shell_exec('sysctl -n machdep.cpu.brand_string');

        } elseif (PHP_OS_FAMILY === 'Windows') {
            // For Windows systems
            $this->cpuModel = shell_exec('wmic cpu get caption');
        }

        return $this->cpuModel ?: 'Unknown';
    }

    public function getMemoryUsage()
    {
        if(PHP_OS_FAMILY === 'Linux'){
            // Execute the command to get memory usage
            $memoryUsage = shell_exec('free -m');

            // Parse the output
            if ($memoryUsage) {
                $memoryLines = explode("\n", trim($memoryUsage));
                $memoryInfo = preg_split('/\s+/', $memoryLines[1]);

                $totalMemory = $memoryInfo[1];
                $usedMemory = $memoryInfo[2];
                $freeMemory = $memoryInfo[3];

                $this->totalMemory = $this->formatMegabytes($totalMemory);
                $this->usedMemory = $this->formatMegabytes($usedMemory);
                $this->freeMemory = $this->formatMegabytes($freeMemory);
                $this->memoryUsagePercentage = round(($usedMemory / $totalMemory) * 100, 2);
            } else {
                // Fallback for systems without 'free' command
                $this->totalMemory = '0 GB';
                $this->usedMemory = '0 GB';
                $this->freeMemory = '0 GB';
                $this->memoryUsagePercentage = '0';
            }
        }else{
            // Fallback for systems without 'free' command
            $this->totalMemory = '0 GB';
            $this->usedMemory = '0 GB';
            $this->freeMemory = '0 GB';
            $this->memoryUsagePercentage = '0';
        }
    }

    public function formatMegabytes($megabytes, $precision = 2)
    {
        return round($megabytes, $precision) . ' MB';
    }

    public function getDiskSpace()
    {
        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskUsedPercentage = ($diskUsed / $diskTotal) * 100;

        // Convert bytes to human-readable format
        $this->diskTotal = $this->formatBytes($diskTotal);
        $this->diskFree = $this->formatBytes($diskFree);
        $this->diskUsed = $this->formatBytes($diskUsed);
        $this->diskUsedPercentage = round($diskUsedPercentage, 2);
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function getServerStartTime()
    {
        $startTime = 'Unknown';

        if (PHP_OS_FAMILY === 'Linux') {
            // For Linux systems
            $uptime = shell_exec('uptime -s');
            if ($uptime) {
                $startTime = date('Y-m-d H:i:s', strtotime($uptime));
            }
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            // For macOS systems
            $uptime = shell_exec('sysctl -n kern.boottime');
            if ($uptime) {
                $uptime = preg_replace('/[^\d]/', '', $uptime);
                $startTime = date('Y-m-d H:i:s', $uptime);
            }
        } elseif (PHP_OS_FAMILY === 'Windows') {
            // For Windows systems
            $uptime = shell_exec('wmic os get lastbootuptime');
            if ($uptime) {
                preg_match('/\d{14}/', $uptime, $matches);
                if (isset($matches[0])) {
                    $startTime = date('Y-m-d H:i:s', strtotime($matches[0]));
                }
            }
        }

        return $startTime;
    }

    public function updateUptime()
    {
        // Get the server start time (replace with your actual server start time)
        if($this->serverStartTime !== 'Unknown'){
            $serverStartTime = strtotime($this->serverStartTime);

        }else{
            $serverStartTime = strtotime('2024-07-19 00:00:00');
        }

        // Calculate uptime difference
        $uptimeSeconds = time() - $serverStartTime;

        // Calculate days, hours, minutes, and seconds
        $this->days = floor($uptimeSeconds / (60 * 60 * 24));
        $this->hours = floor(($uptimeSeconds % (60 * 60 * 24)) / (60 * 60));
        $this->minutes = floor(($uptimeSeconds % (60 * 60)) / 60);
        $this->seconds = $uptimeSeconds % 60;
    }

    public function startTimer()
    {
        // Update time every minute
        $this->emit('updateTime');
        $this->emit('updateUptime');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
