public class Task {
    private String name;
    private int priority;  // Higher number = higher priority
    private int duration;  // Duration in minutes

    // TODO: Constructor to initialize task properties
    public Task(String name, int priority, int duration) {
        this.name = name;
        this.priority = priority;
        this.duration = duration;
    }

    public String getName() {
        return name; // Replace with actual logic
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getPriority() {
        return priority; // Replace with actual logic
    }

    public void setPriority(int priority) {
        this.priority = priority;
    }

    public int getDuration() {
        return duration; // Replace with actual logic
    }

    public void setDuration(int duration) {
        this.duration = duration;
    }

    @Override
    public String toString() {
      return "Task [Name: " + name + ", Priority: " + priority + ", Duration: " + duration + " mins]";
      
      }
      
    @Override
    public boolean equals(Object obj) {
      if (this == obj) return true;
        if (obj == null || getClass() != obj.getClass()) 
           return false;
        Task other = (Task) obj;       
        return name.equalsIgnoreCase(other.name);
    }
}
