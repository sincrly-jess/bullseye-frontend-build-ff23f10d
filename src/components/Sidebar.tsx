import { useState } from "react";
import { Home, Grid3X3, Trophy, MessageCircle, ChevronDown, ChevronRight } from "lucide-react";

interface SidebarProps {
  isOpen: boolean;
  onClose: () => void;
}

const categories = [
  { name: "Bullseye Games", href: "/categories/bullseye-games" },
  { name: "Casino", href: "/categories/casino" },
  { name: "Markets", href: "/categories/markets" },
];

const Sidebar = ({ isOpen, onClose }: SidebarProps) => {
  const [categoriesOpen, setCategoriesOpen] = useState(false);

  return (
    <>
      {/* Overlay */}
      {isOpen && (
        <div
          className="fixed inset-0 bg-black/50 z-40"
          onClick={onClose}
        />
      )}

      {/* Sidebar */}
      <aside
        className={`fixed top-14 left-0 bottom-0 w-64 bg-card border-r border-border z-50 transform transition-transform duration-300 ${
          isOpen ? "translate-x-0" : "-translate-x-full"
        }`}
      >
        <nav className="p-4 space-y-1">
          <a href="/" className="flex items-center gap-3 px-3 py-2 text-foreground hover:bg-muted rounded-lg transition-colors">
            <Home className="w-4 h-4" />
            Home
          </a>

          <div>
            <button
              onClick={() => setCategoriesOpen(!categoriesOpen)}
              className="flex items-center justify-between w-full px-3 py-2 text-muted-foreground hover:text-foreground hover:bg-muted rounded-lg transition-colors"
            >
              <span className="flex items-center gap-3">
                <Grid3X3 className="w-4 h-4" />
                Categories
              </span>
              {categoriesOpen ? (
                <ChevronDown className="w-4 h-4" />
              ) : (
                <ChevronRight className="w-4 h-4" />
              )}
            </button>
            {categoriesOpen && (
              <div className="ml-7 mt-1 space-y-1">
                {categories.map((cat) => (
                  <a
                    key={cat.name}
                    href={cat.href}
                    className="block px-3 py-1.5 text-sm text-muted-foreground hover:text-foreground hover:underline transition-colors"
                  >
                    {cat.name}
                  </a>
                ))}
              </div>
            )}
          </div>

          <a href="/leaderboard" className="flex items-center gap-3 px-3 py-2 text-muted-foreground hover:text-foreground hover:bg-muted rounded-lg transition-colors">
            <Trophy className="w-4 h-4" />
            Leaderboard
          </a>

          <a href="/chat" className="flex items-center gap-3 px-3 py-2 text-muted-foreground hover:text-foreground hover:bg-muted rounded-lg transition-colors">
            <MessageCircle className="w-4 h-4" />
            Chat
          </a>
        </nav>
      </aside>
    </>
  );
};

export default Sidebar;
